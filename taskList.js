
function addTaskList(nk, ps) {
	tasks.sort();
	for(i = 1; i < tasks.length; i++) {
		color="#000";
		if(tasks[i][11]==1) color="#0a0";
		document.getElementById('tasksTable').innerHTML += "<tr><td>"+tasks[i][0]+"</td><td><a href='?login="+nk+"&pass="+ps+"&page=taskview&param1="+tasks[i][1]+"' style='color:"+color+";text-decoration:underline'>"+tasks[i][2]+"</a></td></tr>";
	}
}
