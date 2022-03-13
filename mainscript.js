
$(document).ready(function(){

    
    $("a").click(function(){
    //var text = $(this).attr("class");
        $("a").removeAttr("class")
        $(this).attr("class","active")
        var page = $(this).attr("href");
        page = page.replace("#","")
      
        //localStorage.setItem("page",page)
        if(page == "home"){
            location.href="index.html"
                      
        }else if(page == "createTable"){
            //add data page  
             
            $("#content").load("./"+page+".html");
          
          
        }else{
            //filterpage
            $("#content").load("./"+page+".html");
            
        }
        
        
           
        
    });
});
	
	


    

