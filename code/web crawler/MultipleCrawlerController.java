import java.util.HashMap;
import java.util.Map;

import edu.uci.ics.crawler4j.crawler.CrawlConfig;
import edu.uci.ics.crawler4j.crawler.CrawlController;
import edu.uci.ics.crawler4j.fetcher.PageFetcher;
import edu.uci.ics.crawler4j.robotstxt.RobotstxtConfig;
import edu.uci.ics.crawler4j.robotstxt.RobotstxtServer;



public class MultipleCrawlerController {
		static Map map = new HashMap();
        static Map master = new HashMap();

        public static void main(String[] args) throws Exception {
            master.put("health", 0);
            master.put("sport", 0);
            master.put("justice", 0);
            master.put("living", 0);
            master.put("opinion", 0);
            master.put("politics", 0);
            master.put("tech", 0);
            master.put("travel", 0);
            master.put("americas", 0);
            master.put("world", 0);
            master.put("asia", 0);
            master.put("us", 0);
            master.put("video", 0);
            master.put("showbiz", 0);
            master.put("business", 0);
        	


                String crawlStorageFolder ="U:\\data\\";
                
                CrawlConfig config1 = new CrawlConfig();

                /*
                 * The two crawlers should have different storage folders for their
                 * intermediate data
                 */
                config1.setCrawlStorageFolder(crawlStorageFolder + "/crawler1");

                config1.setPolitenessDelay(100);

                config1.setMaxPagesToFetch(1000000);


                /*
                 * We will use different PageFetchers for the two crawlers.
                 */
                PageFetcher pageFetcher1 = new PageFetcher(config1);

                /*
                 * We will use the same RobotstxtServer for both of the crawlers.
                 */
                RobotstxtConfig robotstxtConfig = new RobotstxtConfig();
                RobotstxtServer robotstxtServer = new RobotstxtServer(robotstxtConfig, pageFetcher1);

                CrawlController controller1 = new CrawlController(config1, pageFetcher1, robotstxtServer);

                String[] crawler1Domains = new String[] { "http://edition.cnn.com/"
                 };

                controller1.setCustomData(crawler1Domains);

                
                int maxDepthOfCrawling = 50;
               // config1.setMaxDepthOfCrawling(maxDepthOfCrawling);

                
                controller1.addSeed("http://edition.cnn.com/");
                
                controller1.addSeed("http://www.cnn.com/WORLD/?hpt=sitenav");
                controller1.addSeed("http://www.cnn.com/POLITICS/?hpt=sitenav");
                controller1.addSeed("http://www.cnn.com/JUSTICE/?hpt=sitenav" );
                controller1.addSeed("http://www.cnn.com/SHOWBIZ/?hpt=sitenav");
                controller1.addSeed("http://www.cnn.com/TECH/?hpt=sitenav");
                controller1.addSeed("http://www.cnn.com/HEALTH/?hpt=sitenav");
                controller1.addSeed("http://www.cnn.com/LIVING/?hpt=sitenav");
                controller1.addSeed("http://www.cnn.com/TRAVEL/?hpt=sitenav");
                controller1.addSeed("http://www.cnn.com/OPINION/?hpt=sitenav" );
				

                controller1.startNonBlocking(BasicCrawler.class, 11);

                controller1.waitUntilFinish();
                
                System.out.println("Crawler is finished.");

        }
}
