package edu.ung.mccb.csci.csci3300.Model;

import java.util.Properties;
import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

public class email {

    //this constructor takes the user's email address
    public email(String emailAddress) {


        // Recipient's email ID needs to be mentioned.
        String to = emailAddress;

        // Sender's email ID needs to be mentioned
        String from = "CSCI3300SecurePoll@gmail.com";
        final String username = "CSCI3300SecurePoll@gmail.com";//change accordingly
        final String password = "SecurePollCSCI3300";//change accordingly


        Properties props = new Properties();
        props.put("mail.smtp.auth", "true");
        props.put("mail.smtp.starttls.enable", "true");
        props.put("mail.smtp.host", "smtp.gmail.com");
        props.put("mail.smtp.port", "587");

        // Get the Session object.
        Session session = Session.getInstance(props,
                new javax.mail.Authenticator() {
                    protected PasswordAuthentication getPasswordAuthentication() {
                        return new PasswordAuthentication(username, password);
                    }
                });

        try {
            // Create a default MimeMessage object.
            Message message = new MimeMessage(session);

            // Set From: header field of the header.
            message.setFrom(new InternetAddress(from));

            // Set To: header field of the header.
            message.setRecipients(Message.RecipientType.TO,
                    InternetAddress.parse(to));

            // Set Subject: header field
            message.setSubject("Login Code to SecurePoll");

            // Now set the actual message
            message.setText("Hello, please enter in the numbers " +
                    "55555 ");

            // Send message
            Transport.send(message);

            System.out.println("Sent message successfully....");

        } catch (
                MessagingException e) {
            throw new RuntimeException(e);
        }
    }
}
