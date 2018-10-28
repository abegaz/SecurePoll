package griffinbean.example.com.securepollmobile.Model;

public class Campaign {
    private String campID;
    private String position;
    private String type;
    private String state;

    public Campaign() {

    }

    public Campaign(String campID, String position, String type, String state) {
        this.campID = campID;
        this.position = position;
        this.type = type;
        this.state = state;
    }

    public String getCampID() {
        return campID;
    }

    public void setCampID(String campID) {
        this.campID = campID;
    }

    public String getPosition() {
        return position;
    }

    public void setPosition(String position) {
        this.position = position;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getState() {
        return state;
    }

    public void setState(String state) {
        this.state = state;
    }
}
