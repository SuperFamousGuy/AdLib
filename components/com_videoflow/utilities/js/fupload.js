// VideoFlow 1.1.2 Upload Utility File //

  var cmes;
  
	function thumbs()
	{
		var thumbs = document.getElementById('thm');
		if(thumbs.checked == true) { window.location = "index.php?thm=1"; }
		else { window.location = "index.php"; }
	}
  
  function closeRefresh(mid, vtask)
  {
   if (vtask === undefined) {
   vtask = 'edit';
   }
   window.location = "index.php?option=com_videoflow&task=thumbstatus&mid="+mid+"&vtask="+vtask; 
  }
  
  function checkup()
  {
  var upstate = document.getElementById('f1_upload_process').style.clear;
  if (cmes === undefined){
  cmes = "Continue with step 2...";
  }
  if (upstate != "both"){
  document.getElementById("f1_upload_process").innerHTML = cmes;
  }
  }

  function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      setTimeout("checkup()", 5000);
      return false;
  }

  function stopUpload(message){
        var frame_name = parent.frames.length;
        if (frame_name > 0 ){
        frame_name = frame_name -1;
        } else {
        frame_name = frame_name;
        }
        var vresult = '<span class="msg">' + message + '<\/span><br/><br/>';  
        window.frames[frame_name].document.getElementById("f1_upload_process").style.clear = "both";   
        window.frames[frame_name].document.getElementById("f1_upload_process").innerHTML = vresult; 
      return true;   
  }