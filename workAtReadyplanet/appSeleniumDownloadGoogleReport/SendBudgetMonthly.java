package com.rp.adpro_sor;

import static org.junit.Assert.fail;

import java.io.File;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Properties;
import java.util.concurrent.TimeUnit;
import java.util.prefs.Preferences;

import javax.activation.*;
import javax.mail.BodyPart;
import javax.mail.Message;
import javax.mail.Multipart;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeBodyPart;
import javax.mail.internet.MimeMessage;
import javax.mail.internet.MimeMultipart;

import org.ini4j.Ini;
import org.ini4j.IniPreferences;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.firefox.FirefoxProfile;

public class SendBudgetMonthly {

	private WebDriver driver;
	private String baseUrl;
	private StringBuffer verificationErrors = new StringBuffer();

	private String ivEMail, ivPassWd, ivLabel, ivRootFolder, ivtargetFolder;

	private List<Integer> countData = new ArrayList<Integer>();

	private String dbHost, dbUser, dbPass;

	public static void main(String[] args) {

		Ini iniFile = null;
		SendBudgetMonthly budget = null;
		try {

			iniFile = new Ini(new File("config.ini"));

			Preferences prefs = new IniPreferences(iniFile);

			budget = new SendBudgetMonthly();

			Preferences mainConfig = prefs.node("main");
			String[] sLabels = mainConfig.get("label", "").split(",");

			budget.setTargetFolder(mainConfig.get("targetFolderServer", ""));

			budget.setDbHost(mainConfig.get("db", ""));
			budget.setDbUser(mainConfig.get("dbUsername", ""));
			budget.setDbPass(mainConfig.get("dbPassword", ""));

			budget.setEMail(mainConfig.get("email", ""));
			budget.setPassWd(mainConfig.get("password", ""));
			budget.setRootFolder(mainConfig.get("downloadFolderServer", ""));

			for (String sLabel : sLabels) {

				budget.setLabel(sLabel);

				budget.setUp();
				budget.executeSaveBudget();

				budget.copyFileToDestination("myclientcenter" + sLabel + ".csv");

			}

			budget.sendMailReport(sLabels);

			budget.tearDown();

		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			System.exit(0);
		}
	}

	private FirefoxDriver getFireFoxDriver() {
		FirefoxProfile fProfile = new FirefoxProfile();
		if (this.getRootFolder() != null && this.getRootFolder().length() > 0) {
			fProfile.setPreference("browser.download.folderList", 2);
			fProfile.setPreference("browser.download.dir", this.getRootFolder());
		}
		fProfile.setPreference("browser.helperApps.neverAsk.saveToDisk",
				"application/csv");

		FirefoxDriver fDriver = new FirefoxDriver(fProfile);

		return fDriver;
	}

	public void setUp() throws Exception {
		driver = getFireFoxDriver();

		baseUrl = "https://accounts.google.com/";
		driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
	}

	private void waitForText(By anElement, String sExpectText) throws Exception {
		for (int second = 0;; second++) {
			if (second >= 30)
				break; // fail("timeout");

			String sGoogleText = "" + driver.findElement(anElement).getText();
			System.out.println("Waiting for Text:" + anElement.toString()
					+ "\t Result :" + sGoogleText);
			try {
				if (sGoogleText.contains(sExpectText)) {
					System.out.println("found");
					return;
				}
			} catch (Exception e) {
			}
			System.out.println("sleep " + second + " sec");
			waitForSeconds(1);
		}
		System.out.println("!!! not found !!! " + anElement.toString());
		waitForSeconds(3);
	}

	public void executeSaveBudget() throws Exception {

		// login to adwords mcc accounts
		driver.get(baseUrl
				+ "/ServiceLogin?service=adwords&continue=https://adwords.google.com/um/identity?hl%3Dth&hl=en&ltmpl=signin&passive=0&skipvpage=true");
		driver.findElement(By.id("Email")).clear();
		driver.findElement(By.id("Email")).sendKeys(this.getEMail());
		driver.findElement(By.id("Passwd")).clear();
		driver.findElement(By.id("Passwd")).sendKeys(this.getPassWd());
		driver.findElement(By.id("signIn")).click();
		System.out.println("Login complete.");
		System.out.println("Page Title:" + driver.getTitle());

		waitForText(By.cssSelector("span.aw-pagination-show-rows > span"),
				"Show rows:");

		driver.findElement(By.linkText(this.getLabel())).click();
		waitForText(By.cssSelector("span.aw-pagination-go-to-page > span"),
				"Go to page:");

		driver.findElement(
				By.xpath("//div[@id='gwt-mcm']/div/div[3]/div[2]/div/div/div[2]/div[4]/div/table/tbody/tr/td[3]/div/div/div[3]/span"))
				.click();
		
		waitForText(
				By.xpath("//div[@id='gwt-mcm']/div/div[3]/div[2]/div/div/div[2]/div[4]/div/div[2]/div/div/div/div/div[3]/div/div/div/div[2]"),
				"");
		// waitForSeconds(3);
		driver.findElement(
				By.xpath("//div[@id='gwt-mcm']/div/div[3]/div[2]/div/div/div[2]/div[4]/div/div[2]/div/div/div/div/div[3]/div/div/div/div[2]"))
				.click();

		waitForSeconds(10); // wait until download complete

		// logout
		driver.findElement(
				By.cssSelector("div.aw-cues-customerpanel.aw-cues-downarrow"))
				.click();
		
		//driver.findElement(By.cssSelector("div.qNKB.qDKB")).click();
		driver.findElement(By.xpath("//div[text()='Sign out']")).click();
		waitForSeconds(3); // wait until login complete
	}

	public void waitForSeconds(int nSec) {
		try {
			System.out.println("delay :" + nSec + " seconds.");
			Thread.sleep(nSec * 1000);
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	}

	private void copyFileToDestination(String fileName) throws Exception {

		DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
		Date date = new Date();
		String folderName = dateFormat.format(date);

		File directory = new File(getTargetFolder() + folderName);

		if (!directory.exists()) {
			System.out.println("creating directory: " + directory.getName());
			boolean result = false;

			directory.mkdir();
			result = true;

			if (result) {
				System.out.println("directory created");
			}
		}

		File sourcefile = new File(getRootFolder() + "myclientcenter.csv");
		if (sourcefile.renameTo(new File(getTargetFolder() + folderName + "/"
				+ folderName + "-" + fileName))) {
			System.out.println("File is moved successful!");
		} else {
			System.out.println("File is failed to move!");
		}

	}

	public void tearDown() throws Exception {
		driver.quit();

		String verificationErrorString = verificationErrors.toString();
		if (!"".equals(verificationErrorString)) {
			fail(verificationErrorString);
		}
	}

	private void sendMailReport(String[] sLabels) throws Exception {
		System.out.println("sending mail...");
				
	    Properties properties = System.getProperties();
	    properties.setProperty("mail.smtp.host", "localhost");
	    
	    Session session = Session.getDefaultInstance(properties);

		DateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy");
		DateFormat dateFormatFile = new SimpleDateFormat("yyyy-MM-dd");
		Date today = new Date();
		
		InternetAddress[] receiver = {
				new InternetAddress("chatchawan@readyplanet.com", "Chatchawan"),
				new InternetAddress("areesa@readyplanet.com", "Areesa"),
				new InternetAddress("saran@readyplanet.com", "Saran"),
				new InternetAddress("janisara@readyplanet.com", "Janisara")};
		
        MimeMessage message = new MimeMessage(session);
        message.setFrom(new InternetAddress("info@readyplanet.com"));
        message.addRecipients(Message.RecipientType.TO, receiver);
        message.setSubject("Monthly remaining budget report");
        
        BodyPart messageBodyPart = new MimeBodyPart();
        messageBodyPart.setText("Last updated : "+ dateFormat.format(today));
        
        Multipart multipart = new MimeMultipart();
        multipart.addBodyPart(messageBodyPart);
        
        for (String sLabel : sLabels) {
        	FileDataSource source = new FileDataSource("/home/grandplanet/SOR/Webpro/data/RemainingBudget/"+ dateFormatFile.format(today) +"/"+ dateFormatFile.format(today) +"-myclientcenter"+ sLabel +".csv");
        	
        	messageBodyPart = new MimeBodyPart();
        	messageBodyPart.setDataHandler(new DataHandler(source));
        	messageBodyPart.setFileName("myclientcenter"+ sLabel +".csv");
        	
        	multipart.addBodyPart(messageBodyPart);
        }

        message.setContent(multipart);

        Transport.send(message);

		System.out.println("send completed...");
	}

	public String getEMail() {
		return ivEMail;
	}

	public void setEMail(String ivEMail) {
		this.ivEMail = ivEMail;
	}

	public String getPassWd() {
		return ivPassWd;
	}

	public void setPassWd(String ivPassWd) {
		this.ivPassWd = ivPassWd;
	}

	public String getLabel() {
		return ivLabel;
	}

	public void setLabel(String ivLabel) {
		this.ivLabel = ivLabel;
	}

	public String getRootFolder() {
		return ivRootFolder;
	}

	public void setRootFolder(String ivRootFolder) {
		this.ivRootFolder = ivRootFolder;
	}

	public String getTargetFolder() {
		return ivtargetFolder;
	}

	public void setTargetFolder(String ivtargetFolder) {
		this.ivtargetFolder = ivtargetFolder;
	}

	public String getDbHost() {
		return dbHost;
	}

	public void setDbHost(String dbHost) {
		this.dbHost = dbHost;
	}

	public String getDbUser() {
		return dbUser;
	}

	public void setDbUser(String dbUser) {
		this.dbUser = dbUser;
	}

	public String getDbPass() {
		return dbPass;
	}

	public void setDbPass(String dbPass) {
		this.dbPass = dbPass;
	}

	public List<Integer> getCountData() {
		return countData;
	}

	public void setCountData(int countData) {
		this.countData.add(countData);
	}

}