
import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.regex.Pattern;

import edu.uci.ics.crawler4j.crawler.Page;
import edu.uci.ics.crawler4j.crawler.WebCrawler;
import edu.uci.ics.crawler4j.parser.HtmlParseData;
import edu.uci.ics.crawler4j.url.WebURL;


public class BasicCrawler extends WebCrawler {

        private final static Pattern FILTERS = Pattern.compile(".*(\\.(xml|css|js|bmp|gif|jpe?g" + "|png|tiff?|mid|mp2|mp3|mp4"
                        + "|wav|avi|mov|mpeg|ram|m4v|pdf" + "|rm|smil|wmv|swf|wma|zip|rar|gz))$");

        private String[] myCrawlDomains;
        


        @Override
        public void onStart() {
                myCrawlDomains = (String[]) myController.getCustomData();

        }

        @Override
        public boolean shouldVisit(WebURL url) {
                String href = url.getURL().toLowerCase();
                if (FILTERS.matcher(href).matches()) {
                        return false;
                }
                for (String crawlDomain : myCrawlDomains) {
                        if (href.startsWith(crawlDomain)) {
                                return true;
                        }
                }
                return false;
        }

        @Override
        public void visit(Page page) {
                int docid = page.getWebURL().getDocid();
                String url = page.getWebURL().getURL();
                int term=0;
                if(!MultipleCrawlerController.map.containsKey(url)){
                	MultipleCrawlerController.map.put(url, 1);
                int parentDocid = page.getWebURL().getParentDocid();
                String[] pagedomain= url.split("/");
                String use="";
                               
                if(url.contains("sport") || url.contains("SPORT"))
                {
                use="sport";
                MultipleCrawlerController.master.put(use, ((int)MultipleCrawlerController.master.get(use))+1);
                }                
                else if(url.contains("business") || url.contains("BUSINESS"))
                {
                use="business";
                MultipleCrawlerController.master.put(use, ((int)MultipleCrawlerController.master.get(use))+1);
                }                
               
                
                
                if(use!=""){
                	int k = (int) MultipleCrawlerController.master.get(use);
                	if(k>4100){term++; System.out.println("Done.");}
                }
                else{
                	term++; System.out.println("skip");
                }
                //System.out.println("use:"+use);
                System.out.println("Docid: " + docid);
                System.out.println("URL: " + url);
                System.out.println("Docid of parent page: " + parentDocid);

                if (page.getParseData() instanceof HtmlParseData && term==0) {
                        HtmlParseData htmlParseData = (HtmlParseData) page.getParseData();
                        String text = htmlParseData.getText();
                        String html = htmlParseData.getHtml();
                        List<WebURL> links = htmlParseData.getOutgoingUrls();
                        FileWriter fstream;
                        
						try {
							fstream = new FileWriter("U:\\data\\new_html\\"+use+"_"+docid +".txt");
	                        BufferedWriter out = new BufferedWriter(fstream);
		                    out.write(html);
		                    out.close();
							fstream = new FileWriter("U:\\data\\new_text\\"+use+"_"+docid +".txt");
	                        BufferedWriter outs = new BufferedWriter(fstream);
		                    outs.write(text);
		                    outs.close();		                    System.out.println("Written.");
						} catch (IOException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}
                }

                System.out.println("=============");
                }
                //term_exec:;
        }
}
