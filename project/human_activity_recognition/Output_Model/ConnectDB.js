    private var max : float = 0;
    private var min : float = 0;
    private var temp : float = 0;
    private var x : float = 0;
    private var type : int = 0;
    private var split : String[];
     
    private var URL = "http://thebear.efresh.in.th/finalproject/getActivity.php";
    /*private var URL = "http://10.1.134.112:92/finalProject/getActivity.php";
    private var URL = "http://10.1.144.75:92/finalProject/getActivity.php";
    private var URL = "http://localhost/finalProject/getActivity.php";*/
   
    function getActivity() {
        var form = new WWWForm();
        form.AddField( "X", temp );
        var w = WWW(URL, form);
        yield w;
        if (w.error != null) {
            print(w.error);
        } else {
            split = w.data.Split(","[0]);
            setData(parseFloat(split[0]),parseFloat(split[1]),parseFloat(split[2]));
            w.Dispose();
        }
    }
    function setData(dataMax : float,dataMin : float,dataType : int){
    	max = dataMax;
    	min = dataMin;
    	type = dataType;
    	//Debug.Log("temp : "+temp);
    }
    function getData(): int{
    	if(max - min < 2 || temp.Equals(max - min)){x = 0;}
    	else if(min <= 4.566341){
    		if(max <= 12.154165){
    			if(min <= 0.46268){x = 1;}//Jump
    			else{x = 2;}//Sit
    		}
    		else{x = 1;}//Jump
    	}
    	else if(min > 4.566341){
    		x = 2;//Sit
    	}
    	if(x == 2 && type == 2){x = 3;}//Stand
		temp = max - min;
    	return x;
    }