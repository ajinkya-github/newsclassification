import java.io.BufferedWriter;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.TreeSet;

import org.apache.mahout.cf.taste.common.TasteException;
import org.apache.mahout.cf.taste.eval.RecommenderEvaluator;
import org.apache.mahout.cf.taste.impl.common.LongPrimitiveIterator;
import org.apache.mahout.cf.taste.impl.eval.AverageAbsoluteDifferenceRecommenderEvaluator;
import org.apache.mahout.cf.taste.impl.model.file.FileDataModel;
import org.apache.mahout.cf.taste.impl.neighborhood.NearestNUserNeighborhood;
import org.apache.mahout.cf.taste.impl.recommender.GenericUserBasedRecommender;
import org.apache.mahout.cf.taste.impl.similarity.AveragingPreferenceInferrer;
import org.apache.mahout.cf.taste.impl.similarity.PearsonCorrelationSimilarity;
import org.apache.mahout.cf.taste.model.DataModel;
import org.apache.mahout.cf.taste.neighborhood.UserNeighborhood;
import org.apache.mahout.cf.taste.recommender.RecommendedItem;
import org.apache.mahout.cf.taste.recommender.Recommender;
import org.apache.mahout.cf.taste.similarity.UserSimilarity;

import au.com.bytecode.opencsv.CSVReader;

public final class RecommendKNN {
	public static void main(String... args) throws FileNotFoundException,
			TasteException, IOException {
		RecommenderEvaluator evaluator = new AverageAbsoluteDifferenceRecommenderEvaluator();
		File ratingsFile = new File("/home/anoop/239/rating.csv");
		DataModel dataModel = new FileDataModel(ratingsFile);

		String csvFilename = "/home/anoop/239/title.csv";
		String csv = "/home/anoop/239/rating.csv";
		int count = 1;
		CSVReader csvReader = new CSVReader(new FileReader(csvFilename));
		CSVReader csvReader2 = new CSVReader(new FileReader(csv));
		String[] row = null;
		String[] row2 = null;
		StringBuffer data = new StringBuffer();

		Map article = new HashMap<String, String>();
		Map rating = new HashMap<String, TreeSet<String>>();
		while ((row = csvReader.readNext()) != null) {
			if (row[1] != "") {
				article.put(Integer.toString(count), row[1]);
				count++;
			}
		}

		while ((row2 = csvReader2.readNext()) != null) {
			TreeSet c = new TreeSet<String>();
			if (rating.containsKey(row2[0])) {
				c = (TreeSet) rating.get(row2[0]);
				c.add(row2[1]);
			} else {
				c.add(row2[1]);
				rating.put(row2[0], c);
			}
		}

		File file = new File("/home/anoop/239/recommdations_KNN.txt");
		FileWriter fw = new FileWriter(file.getAbsoluteFile());
		BufferedWriter bw = new BufferedWriter(fw);
		if (!file.exists()) {
			file.createNewFile();
		}

		UserSimilarity userSimilarity;
		userSimilarity = new PearsonCorrelationSimilarity(dataModel);
		userSimilarity.setPreferenceInferrer(new AveragingPreferenceInferrer(
				dataModel));

		UserNeighborhood neighborhood = new NearestNUserNeighborhood(100,
				userSimilarity, dataModel);

		Recommender recommender = new GenericUserBasedRecommender(dataModel,
				neighborhood, userSimilarity);

		for (LongPrimitiveIterator it = dataModel.getUserIDs(); it.hasNext();) {
			long userId = it.nextLong();

			// get the recommendations for the user
			List<RecommendedItem> recommendations = recommender.recommend(
					userId, 5);

			TreeSet st = (TreeSet<String>) rating.get(String.valueOf(userId));
			Iterator itst = st.iterator();
			bw.write("Articles read by " + userId + ": ");
			bw.newLine();
			while (itst.hasNext()) {
				String temp = (String) itst.next();
				bw.write(article.get(temp).toString());
				bw.newLine();
			}
			bw.newLine();
			bw.newLine();

			bw.write("Articles recommended for " + userId + ": ");
			bw.newLine();

			if (recommendations.size() == 0) {
				bw.write("No recommendations available for this user.");
				bw.newLine();
			}
			System.out.println(userId);
			for (RecommendedItem recommendedItem : recommendations) {
				bw.write(article.get(
						String.valueOf(recommendedItem.getItemID())).toString());
				bw.newLine();
			}
			bw.newLine();
			bw.write("---------------------------------------------------------------------------------");
			bw.newLine();
			bw.newLine();
		}
		bw.newLine();
		bw.write("*********************************************************************************");
		bw.newLine();
		bw.newLine();
		bw.close();
	}
}