function reload() {
   	location.reload();
}

$(document).on("keyup", "input:text[numberOnly]", function() {

	$(this).number(true);

});

function comma(num){
    var len, point, str; 
       
    num = num + ""; 
    point = num.length % 3 ;
    len = num.length; 
   
    str = num.substring(0, point); 
    while (point < len) { 
        if (str != "") str += ","; 
        str += num.substring(point, point + 3); 
        point += 3; 
    } 
     
    return str;
}


function pad2(n) { return n < 10 ? '0' + n : n }


function saveExcel(SaveFileName)
{
	// 여기서부터 테이블 데이터를 재구축.
	/*
	var th = $(_table.table().header())[0].outerText;
	
	th = th.replace(/\n/, " ");
	th = th.replace(/\t/, " ");
	th = th.replace(/  /, " ");
	th = th.split(" ");
	*/
	var th = [];
	
	$("thead th").each(function(i,e) {
		th.push($(this).html());
	});	
	
	var _html = "<table><thead><tr>";
	
	for(var i=0; i<th.length; i++)
		_html += "<th>" + th[i] + "</th>";
	
	_html += "</tr></thead><tbody>";
	
	
	var _data;
	
	_table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
	    var data = this.data();
	   // ... do something with data(), or this.node(), etc

	    
	    _html += "<tr>";
	
	    for(var i=0; i<data.length; i++)
	    {
	    	_data = data[i].split("<a")[0];
	    	_html += "<td>" + _data + "</td>";
	    }
	    
	    _html += "</tr>";
	});
	
	_html += "</tbody></table>";
	
	
	/*
	
	var fn_front = "";
    
    switch(url) {
    	
    case "add-purchase":
    	fn_front = "매입B";
    	break;
    	
    case "add-sales":
    	fn_front = "매출B";
    	break;
    	
    case "add-company-self":
    	fn_front = "자회사";
    	break;
    	
    case "add-company":
    	fn_front = "거래처";
    	break;
    	
    case "add-type-purchase":
    	fn_front = "매입품목";
    	break;
    	
    case "add-type-sales":
    	fn_front = "매출품목";
    	break;
    }
    

	var a = document.createElement('a');
	a.href = ee.getXLSDataURI();
	a.download = fn_front + '_' + _date + '.xls';
	a.click();
	*/

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 
    var sa;

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
    	
    	$("#ifr-hidden").get(0).contentDocument.open("txt/html","replace");
    	$("#ifr-hidden").get(0).contentDocument.write(_html);
    	$("#ifr-hidden").get(0).contentDocument.close();
    	$("#ifr-hidden").focus(); 
    	sa = $("#ifr-hidden").get(0).contentDocument.execCommand("SaveAs",true,"Global View Task.xls");
    }  
    else //other browser not tested on IE 11
    {
    	sa = window.open('data:application/vnd.ms-excel,' + _html);
    }
    
    return (sa);
}



//엑셀 XLS 파일 다운 
$(".dl-xls").click(function(){
	
	saveExcel('text');
	
	//_table.multiGet();
	
	/*

    var date = new Date();
    var _date = date.getFullYear().toString() + pad2(date.getMonth() + 1) + pad2( date.getDate()) + pad2( date.getHours() ) + pad2( date.getMinutes() ) + pad2( date.getSeconds());
    
    var url = window.location.href;
    var arr = url.split("/");
    arr = arr[arr.length-1].split("?");
    url = arr[0].split(".")[0];
    
    var fn_front = "";
    
    switch(url) {
    	
    case "add-purchase":
    	fn_front = "매입B";
    	break;
    	
    case "add-sales":
    	fn_front = "매출B";
    	break;
    	
    case "add-company-self":
    	fn_front = "자회사";
    	break;
    	
    case "add-company":
    	fn_front = "거래처";
    	break;
    	
    case "add-type-purchase":
    	fn_front = "매입품목";
    	break;
    	
    case "add-type-sales":
    	fn_front = "매출품목";
    	break;
    }
    
    var ee = excelExport("dataTable").parseToCSV().parseToXLS("excelexport sheet");

    var a = document.createElement('a');
    a.href = ee.getXLSDataURI();
    a.download = fn_front + '_' + _date + '.xls';
    a.click();
    */
});


function random_rgba() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ', 255)';
    //return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
}

// 카드 접었다 폈다.
$(".card-toggle").click(function(){
    $(this).parent().parent().find('.card-body').slideToggle();
    $(this).parent().parent().find('.card-footer').slideToggle();

    if($(this).find('i').hasClass('fa-chevron-up')) {
        
    	$(this).find('i').removeClass('fa-chevron-up');
        $(this).find('i').addClass('fa-chevron-down');        
    }else{

    	$(this).find('i').removeClass('fa-chevron-down');
        $(this).find('i').addClass('fa-chevron-up');
    }
});

