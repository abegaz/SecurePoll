package griffinbean.example.com.securepollmobile.Controller;

import android.app.Activity;
import android.app.Dialog;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.TextView;
import griffinbean.example.com.securepollmobile.R;

/**
 *  Basic functionality for a simple yes/no dialog box. Box is dismissed when the user presses No
 */
public class ConfirmDialogClass extends Dialog implements android.view.View.OnClickListener
{
    public Activity c;
    public Button yes, no;
    public TextView confirm;

    public ConfirmDialogClass(Activity a)
    {
        super(a);
        this.c = a;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.confirmvotedialog);
        yes = findViewById(R.id.yesBtn);
        no = findViewById(R.id.noBtn);
        confirm = findViewById(R.id.txtDiaConfirm);
        yes.setOnClickListener(this);
        no.setOnClickListener(this);
    }

    @Override
    public void onClick(View v)
    {
        switch (v.getId())
        {
            case R.id.noBtn:
                dismiss();
                break;
        }
    }
}