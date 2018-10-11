package edu.ung.mccb.csci.csci3300.Model;


import java.util.Random;

//this class is used to login/register a user
public class loginModel {

    private int authCode =0;

    public int getAuthCode() {
        return authCode;
    }

    public void setAuthCode(int authCode) {
        this.authCode = authCode;
    }

    //generates the authentification code
    public void generateAuthCode(){
        Random rand = new Random();
        setAuthCode(rand.nextInt(10000)+1);
    }

    //compares the authentification code to what the user typed
    public boolean checkAuth(int authCode){
        if(getAuthCode()==authCode) {
            System.out.println("Auth code correct");
            return true;
        }
            return false;
    }
}
