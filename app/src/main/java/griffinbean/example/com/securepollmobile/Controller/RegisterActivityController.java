package griffinbean.example.com.securepollmobile.Controller;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import griffinbean.example.com.securepollmobile.Model.User;
import griffinbean.example.com.securepollmobile.R;
import java.nio.charset.Charset;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.security.SecureRandom;
import java.util.Calendar;
import java.util.Random;

public class RegisterActivityController extends AppCompatActivity {

    static final String AlphaNum = "1234567890qwertyuiop";
    static SecureRandom randomSalt = new SecureRandom();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.registeractivity);
    }

    /**
     *  Method for touching the Register button, performs input validation, creates a User object, sends it to the User
     *  model for insertion into the Firebase database
     */
    public void touchRegister(View view) {
        Random rand = new Random();
        boolean DoBTrue = false,
                SSNTrue = false,
                VIDTrue = false,
                EmailTrue = false,
                PassTrue = false;
        EditText txtFname = findViewById(R.id.txtFname);
        EditText txtLname = findViewById(R.id.txtLname);
        EditText txtState = findViewById(R.id.txtState);
        EditText txtDob = findViewById(R.id.txtDoB);
        EditText txtSSN = findViewById(R.id.txtSSN);
        EditText txtVoterID = findViewById(R.id.txtVoterID);
        EditText txtEmail = findViewById(R.id.txtEmail);
        EditText txtConfirmEmail = findViewById(R.id.txtConfirmEmail);
        EditText txtPassword = findViewById(R.id.txtPassword);
        String PassSalt = AlphaNum + generateRandomSalt(14);
        String SSNSalt = AlphaNum + generateRandomSalt(14);
        String userIDP1 = txtFname.getText().toString().substring(0, 1);
        String userIDP2 = txtLname.getText().toString();
        int userIDP3num = rand.nextInt(9000) + 1000;
        String userIDP3 = String.valueOf(userIDP3num);
        String userID = userIDP1 + userIDP2 + userIDP3;
        int UserYear, year;

        /**
         *  Date of Birth validation
         */
        if (!txtDob.getText().toString().equals("")) {
            if (txtDob.getText().toString().matches("([0-9]+){2}(/|-)([0-9]+){2}(/|-)([0-9]+){4}")) {
                if (Integer.parseInt(txtDob.getText().toString().substring(0, 2)) > 12) {
                    DoBTrue = false;
                    Toast.makeText(this, "Please enter a valid date", Toast.LENGTH_LONG).show();
                } else if (Integer.parseInt(txtDob.getText().toString().substring(3, 5)) > 31) {
                    DoBTrue = false;
                    Toast.makeText(this, "Please enter a valid date", Toast.LENGTH_LONG).show();
                } else if (Integer.parseInt(txtDob.getText().toString().substring(6, 10)) > Calendar.getInstance().get(Calendar.YEAR)) {
                    DoBTrue = false;
                    Toast.makeText(this, "Please enter a valid date", Toast.LENGTH_LONG).show();
                } else {
                    UserYear = Integer.parseInt(txtDob.getText().toString().substring(6, 10));
                    year = Calendar.getInstance().get(Calendar.YEAR);
                    if (year - UserYear >= 18) {
                        DoBTrue = true;
                    } else {
                        DoBTrue = false;
                        Toast.makeText(this, "You are too young to vote in this country", Toast.LENGTH_LONG).show();
                        Intent intent = new Intent(this, HomePageActivityController.class);
                        startActivity(intent);
                        finish();
                    }
                }
            } else {
                DoBTrue = false;
                Toast.makeText(this, "Date is in the wrong format", Toast.LENGTH_LONG).show();
            }
        } else {
            DoBTrue = false;
            Toast.makeText(this, "Please enter your Date of Birth", Toast.LENGTH_LONG).show();
        }
        /**
         *  SSN validation
         */
        if (txtSSN.getText().toString().matches("([0-9]){4}")) {
                SSNTrue = true;
        } else {
            SSNTrue = false;
            Toast.makeText(this, "Please ensure you entered 4 digits for your SSN", Toast.LENGTH_LONG).show();
        }
        /**
         *  Voter ID validation
         */
        if (txtVoterID.getText().toString().matches("([0-9]){10}")) {
            VIDTrue = true;
        } else {
            VIDTrue = false;
            Toast.makeText(this, "Your VoterID number should be 10 digits", Toast.LENGTH_LONG).show();
        }
        /**
         *  Email validation (sends email and confirmation email to validate email method)
         */
        if (validateEmail(txtEmail.getText().toString(), txtConfirmEmail.getText().toString())) {
            EmailTrue = true;
        }
        /**
         *  password validation (sends password to validatepassword method)
         */
        if (validatePassword(txtPassword.getText().toString())) {
            PassTrue = true;
        }
        /**
         *  Creates a User object if all the above alidation conditions are passed
         */
        if (DoBTrue && SSNTrue && VIDTrue && EmailTrue && PassTrue && !txtFname.getText().toString().equals("")
                && !txtLname.getText().toString().equals("") && !txtState.getText().toString().equals("")) {
            User newUser = new User();
            newUser.setUserID(userID);
            newUser.setFirstName(txtFname.getText().toString());
            newUser.setLastName(txtLname.getText().toString());
            newUser.setDateOfBirth(txtDob.getText().toString());
            newUser.setState(txtState.getText().toString());
            newUser.setSSN(getSecurePassword(txtSSN.getText().toString() + SSNSalt));
            newUser.setVoterID(txtVoterID.getText().toString());
            newUser.setEmail(txtEmail.getText().toString());
            newUser.setPassword(getSecurePassword(txtPassword.getText().toString() + PassSalt));
            newUser.insertUsertoFirebase(newUser.getFirebaseRefforUser(userID), newUser, PassSalt, SSNSalt);
            Intent intent = new Intent(this, LoginActivityController.class);
            startActivity(intent);
            finish();
        } else {
            Toast.makeText(this, "Please ensure all of the above data is the correct format, " +
                    "and that the Name fields and State field are not blank", Toast.LENGTH_LONG).show();
        }
    }

    /**
     *  Hashes the password with the appended salt in SHA-512
     */
    private String getSecurePassword(String passwordToHash) {
        String generatedPassword = null;
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-512");
            byte[] bytes = md.digest(passwordToHash.getBytes(Charset.forName("UTF-8")));
            StringBuilder sb = new StringBuilder();
            for (int i = 0; i < bytes.length; i++) {
                sb.append(Integer.toString((bytes[i] & 0xff) + 0x100, 16).substring(1));
            }
            generatedPassword = sb.toString();
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
        }
        return generatedPassword;
    }

    /**
     *  For generating random salt for passwords
     */
    String generateRandomSalt(int len) {
        StringBuilder sb = new StringBuilder(len);
        for (int i = 0; i < len; i++)
            sb.append(AlphaNum.charAt(randomSalt.nextInt(AlphaNum.length())));
        return sb.toString();
    }

    /**
     *  Email validation
     */
    private boolean validateEmail(String email, String cEmail) {
        if (email.equals(cEmail)) {
            if (email.matches("([a-zA-Z0-9]+)@([a-zA-Z0-9]+)\\.([a-z]+)")) {
                return true;
            } else {
                Toast.makeText(this, "Please enter a valid email address", Toast.LENGTH_LONG).show();
                return false;
            }
        } else {
            Toast.makeText(this, "Please ensure the email fields match", Toast.LENGTH_LONG).show();
            return false;
        }
    }

    /**
     *  Password validation
     */
    private boolean validatePassword(String password) {
        if (password.matches("(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&]).*")) {
            return true;
        }
        else {
            Toast.makeText(this, "Password should be at least 8 characters long and contain at " +
                    "least 1 Uppercase letter, 1 Lowercase letter, 1 digit, and 1 special character", Toast.LENGTH_LONG).show();
            return false;
        }
    }
}