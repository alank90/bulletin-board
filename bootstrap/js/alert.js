/* AlertJS by Mark Jones.

	Sorry for the messy script (Random jquery scripts which are unused, Strange 0.000000001's, sorry about that.)
*/

function openNotice(onid) {
	var height;
	var noticelock = document.getElementById(onid);
	noticelock.setAttribute('style', 'display: block;');
	noticelock.setAttribute('style', 'height: 0px;');
	
	
	/*
	if(typeof jQuery !== 'undefined') {
		$('input[type=submit]').attr('disabled',true);
	}
	
	document.getElementsByTagName('a')[0].removeAttribute('href');
	*/
	
	/*
	
	if(typeof jQuery !== 'undefined') {
		$("#post_btn").click(function(){
			$("body > div:not(.popup)").fadeTo("slow",0.4);
		});
	} else {
		throw new Error("No JQuery installation detected.");
	}
	
	*/
	
	document.body.style.overflowY = "hidden";
	document.body.style.overflowX = "hidden";
	
	(function () {
    var timeLeft = 0,
        cinterval;

    var timeDec = function (){
        timeLeft++;
        document.getElementById(onid).setAttribute('style', 'height: '+Math.floor(timeLeft * 6)+'px;');
        if(timeLeft == 27) {
            clearInterval(cinterval);
        }
    };


	
    cinterval = setInterval(timeDec, 0.000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001);
	})();
}

function closeNotice(onid) {
	document.body.style.overflowY = "visible";
	document.body.style.overflowX = "visible";
	var noticelock = document.getElementById(onid);
	noticelock.setAttribute('style', 'display: none;');
}

/*
function warnNotice(onid) {
	var rand;
	var noticelock = document.getElementById(onid);
	noticelock.setAttribute('class', 'noticeImportant');
	
	function flash() {
		rand=Math.floor((Math.random() * 100) + 1);
		if(rand > 50) {
			noticelock.setAttribute('class', 'noticeImportantStageTwo')
		} else if (rand < 50) {
			noticelock.setAttribute('class', 'noticeImportant')
		} else if (rand == 50) {
			noticelock.setAttribute('class', 'noticeImportantStageTwo')
		} else {
			noticelock.setAttribute('class', 'noticeImportant')
		}
		setInterval(flash, 1000);
	}
	
	flash();
}
*/

// Only use the above if you and your veiwers have a fast PC

/*
document.getElementsByTagName('body')[0].createAttribute("style");
document.getElementsByTagName('body')[0].setAttribute("style", "background-color: grey;");
*/

var bodylength = document.body.innerHTML.length;
if(bodylength >= 500) {
	console.log('AlertJS may crash the browser.');
} else {
	console.log('AlertJS is in the correct enviroment.');
}
