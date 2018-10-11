package edu.ung.mccb.csci.csci3300.Controller;

import edu.ung.mccb.csci.csci3300.Model.loginModel;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;
import javafx.fxml.FXMLLoader;

import javafx.scene.Scene;
import javafx.stage.Stage;

public class authenticationController {

    @FXML
    TextField authField;

    @FXML
    private Stage stage;
    private AnchorPane root;
    private Scene scene;

    @FXML
    private Button authenticateButton;

    //checks entered authentication code
    public void checkAuthCode(ActionEvent event) throws Exception {
        loginModel loginModel = new loginModel();
        if(authField.getText().isEmpty()){
            //alert that code is wrong
            System.out.println("The code entered was incorrect");
        }else {
            if (loginModel.checkAuth(Integer.parseInt(authField.getText()))) {
                stage = (Stage) ((Button) event.getSource()).getScene().getWindow();
                root = FXMLLoader.load(getClass().getResource("edu/ung/mccb/csci/csci3300/View/resultView.fxml"));
                scene = new Scene(root);
                stage.setScene(scene);

            } else {
                //alert that code is wrong
                System.out.println("The code entered was incorrect");
            }
        }
    }

}
