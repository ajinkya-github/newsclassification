
if [ "$1" = "--help" ] || [ "$1" = "--?" ]; then
  echo "This script clusters the cnn data set using a variety of algorithms."
  exit
fi

SCRIPT_PATH=${0%/*}
if [ "$0" != "$SCRIPT_PATH" ] && [ "$SCRIPT_PATH" != "" ]; then 
  cd $SCRIPT_PATH
fi



algorithm=(kmeans dirichlet)
if [ -n "$1" ]; then
  choice=$1
else
  echo "Please select a number to choose the corresponding clustering algorithm"
  echo "1. ${algorithm[0]} clustering"
  echo "2. ${algorithm[1]} clustering"
  read -p "Enter your choice : " choice
fi

echo "ok. You chose $choice and we'll use ${algorithm[$choice-1]} Clustering"
clustertype=${algorithm[$choice-1]} 

hadoop fs -mkdir -p cnn_cluster/cnn-seqdir
mahout seqdirectory -i cnn_cluster/data -o cnn_cluster/cnn-seqdir -c UTF-8 -chunk 5


if [ "x$clustertype" == "xkmeans" ]; then
  mahout seq2sparse \
    -i cnn_cluster/cnn-seqdir/ \
    -o cnn_cluster/cnn-seqdir-sparse-kmeans --maxDFPercent 85 --namedVector \
  && \
  mahout kmeans \
    -i cnn_cluster/cnn-seqdir-sparse-kmeans/tfidf-vectors/ \
    -c cnn_cluster/cnn-kmeans-clusters \
    -o cnn_cluster/cnn-kmeans \
    -dm org.apache.mahout.common.distance.CosineDistanceMeasure \
    -x 10 -k 20 -ow --clustering \
  && \
  mahout clusterdump \
    -i cnn_cluster/cnn-kmeans/clusters-*-final \
    -o cnn_cluster/cnn-kmeans/clusterdump \
    -d cnn_cluster/cnn-seqdir-sparse-kmeans/dictionary.file-0 \
    -dt sequencefile -b 100 -n 5 --evaluate -dm org.apache.mahout.common.distance.CosineDistanceMeasure -sp 0 \
    --pointsDir cnn_cluster/cnn-kmeans/clusteredPoints
 
elif [ "x$clustertype" == "xdirichlet" ]; then
  mahout seq2sparse \
    -i cnn_cluster/cnn-seqdir/ \
    -o cnn_cluster/cnn-seqdir-sparse-dirichlet  --maxDFPercent 85 --namedVector \
  && \
  mahout dirichlet \
    -i cnn_cluster/cnn-seqdir-sparse-dirichlet/tfidf-vectors \
    -o cnn_cluster/cnn-dirichlet -k 20 -ow -x 20 -a0 2 \
    -md org.apache.mahout.clustering.dirichlet.models.DistanceMeasureClusterDistribution \
    -mp org.apache.mahout.math.DenseVector \
    -dm org.apache.mahout.common.distance.CosineDistanceMeasure \
  && \
  mahout clusterdump \
    -i cnn_cluster/cnn-dirichlet/clusters-*-final \
    -o cnn_cluster/cnn-dirichlet/clusterdump \
    -d cnn_cluster/cnn-seqdir-sparse-dirichlet/dictionary.file-0 \
    -dt sequencefile -b 100 -n 20 -sp 0

else 
  echo "unknown cluster type: $clustertype"
fi 
