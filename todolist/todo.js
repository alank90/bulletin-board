
var user_list_timeout;
var current_list_timeout;
var seconds_between_user_list_update = 60000;
var seconds_between_todo_list_update = 5000;
var request;

function displayLogin() {
    var theForm = "<form>Name: <input type='text' name='name'><br> " +
         "Password: <input type='password' name='password'> " +
         "<input type='button' value='submit' onClick='doLogin(this.form);'><br>"
        document.getElementById("loginArea").innerHTML = theForm;
   }
   
   
function doLogin(my_form) {
    readFileDoFunction("userInfo.xml", "GET", function() {
      if (request.readyState == 4) {
      if (request.status == 200) {
      processLogin(request.responseXML, my_form);
      } 
      else {
        document.getElementById("errorDiv").innerHTML =
        "Sorry, there was a problem with the server.";
       }
     }
   }
 );
}


function getUser(user_info, user_name) {
 var users = user_info.getElementsByTagName("user");
 var count = 0;
 var found_user = null;
 var this_user;
 while ((count < users.length) && (found_user == null)) {
   this_user = users[count];
   this_name = getFirstValue(this_user, "name");
   //this_user.getElementsByTagName("name")[0].firstChild.nodeValue;
   if (this_name == user_name) {
     found_user = this_user;
    }
   count++;
 }
return found_user;
}


function processLogin(user_info, my_form) {
 var user_name = my_form.elements["name"].value;
 var user_password = my_form.elements["password"].value;
 var this_password_node;
 var success = false;
 var this_password;
 var this_user = getUser(user_info, user_name);
 if (this_user != null) {
   this_password = getFirstValue(this_user, "password");
    if (user_password == this_password) {
    success = true;
     }
  }
  
 if (success == true) {
   document.cookie = "user=" + user_name;
   displayHomeInformation(user_name);
   document.getElementById("contentArea").innerHTML = "";
  } 
  else {
   document.getElementById("errorDiv").innerHTML +=
   "<font color='red'><br>Login error; please try again.</font>";
   }
 }
 
 
   function displayHomeInformation(user_name) {
    document.getElementById("loginArea").innerHTML = "<h3>Welcome, "  + user_name + ". <br>" + "<a href='#' onClick='logout(); return false'>logout</a> </h3>";
    displayLegalLists(user_name);
}


function readFileDoFunction(file_name, request_type, the_function) {
  if (window.XMLHttpRequest) {
    request = new XMLHttpRequest();
  } 
  else {
    request = new ActiveXObject("Microsoft.XMLHTTP");
  }
  
 var theURL = "/bb/todolist/readXMLFile.php?fileName=" + file_name + "&t=" + new Date().getTime();
 if (request) {
   request.open(request_type, theURL);
   request.onreadystatechange = the_function;
   request.send(null);
  } 
  
  else {
    document.getElementById("errorDiv").innerHTML =
    "Sorry, you must update your browser before seeing Ajax in action.";
   }
 }
 
 
function saveFileDoFunction(file_name, the_contents, the_function) {
  if (window.XMLHttpRequest) {
    request = new XMLHttpRequest();
  } 
  else {
   request = new ActiveXObject("Microsoft.XMLHTTP");
  }
 var the_url = "/bb/todolist/saveXMLFile.php?t=" + new Date().getTime();
 var the_message = "fileName=" + file_name + "&contents=" + the_contents;
 if (request) { 
   request.open("POST", the_url);
   request.setRequestHeader("Content-type",
    "application/x-www-form-urlencoded; charset=UTF-8");
   request.onreadystatechange = the_function;
   request.send(the_message);
 } 
 else {
  document.getElementById("errorDiv").innerHTML =
  "Sorry, you must update your browser before seeing Ajax in action.";
  }
 }
 
 
function displayLegalLists(user_name) {
  readFileDoFunction("userInfo.xml", "GET", function() {
    if (request.readyState == 4) {
    if (request.status == 200) {
      var last_modified = request.getResponseHeader("Last-Modified");
      var last_modified_date = new Date(last_modified);
      displayLists(request.responseXML, user_name, last_modified_date.getTime());
    } 
   else {
    document.getElementById("errorDiv").innerHTML =
   "Sorry, your lists could not be displayed due to a problem with " +
   "the server.";
     }
    }
   }
 );
}



function displayLists(user_info, user_name, last_modified_date) {
 var this_user = getUser(user_info, user_name);
 var display_info = "";
 var this_link;
 var this_list;
 if (this_user != null) {
   var lists_element = this_user.getElementsByTagName("lists")[0];
   var lists = lists_element.getElementsByTagName("list");
   for (var loop = 0; loop < lists.length; loop++) {
     this_list = lists[loop].firstChild.nodeValue;
     this_link = "<a href=\"#\" onClick=\"readyDisplayList('" +
     this_list + "'); return false;\">" + this_list + "</a>";
     display_info += this_link + "<br>";
    }
  document.getElementById("listArea").innerHTML = display_info;
  user_list_timeout =
  setTimeout("updateUserIfChanged(" + last_modified_date + ",'" +
  user_name + "')", seconds_between_user_list_update);
 }
}


function updateUserIfChanged(current_last_modified, user_name) {
  readFileDoFunction("userInfo.xml", "HEAD", function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        var last_modified = request.getResponseHeader("Last-Modified");
        var last_modified_date = new Date(last_modified).getTime();
        if (last_modified_date != current_last_modified) {
          displayLegalLists(user_name);
         }
       user_list_timeout = setTimeout("updateUserIfChanged(" +
       last_modified_date + ",'" + user_name + "')",seconds_between_user_list_update);
      }
     else {
      document.getElementById("errorDiv").innerHTML =
      "Problem updating user " + request.status;
      }
     }
    }
 );
}


function updateTodoIfChanged(current_last_modified, list_name) {
 readFileDoFunction(list_name + ".xml", "HEAD", function() {
   if (request.readyState == 4) {
     if (request.status == 200) {
       var last_modified = request.getResponseHeader("Last-Modified");
       var last_modified_date = new Date(last_modified).getTime();
         if (last_modified_date != current_last_modified) {
            readyDisplayList(list_name);
          }
      todo_list_timeout = setTimeout("updateTodoIfChanged(" +
      last_modified_date + ",'" + list_name + "')", seconds_between_todo_list_update);
      } 
     else {
       document.getElementById("errorDiv").innerHTML =
       "Problem updating To Do list " + request.status;
     }
    }
   }
 );
}


function addNewItem(the_form, list_name) {
 var file_name = list_name + ".xml";
 readFileDoFunction(file_name, "GET", function() {
   if (request.readyState == 4) {
     if (request.status == 200) {
       addNewToFile(request.responseXML, the_form.newItem.value,
       list_name);
      } 
      else {
       document.getElementById("errorDiv").innerHTML = "Sorry, new item could not be added to To Do list for" + list_name +
        " due to a problem with the server.";
      }
     }
    }
  );
}


function addNewToFile(the_document, new_contents, list_name) {
 var open_items = getItems(the_document,"openitems");
 var done_items = getItems(the_document,"doneitems");
 var high_number = getHighValue(the_document);
 var new_number = high_number + 1;
 var new_item = document.createElement("item");
 var new_item_number = document.createElement("number");
 var new_item_content = document.createElement("contents");
 new_item_number.appendChild(document.createTextNode(new_number));
 new_item_content.appendChild(document.createTextNode(new_contents));
 new_item.appendChild(new_item_number);
 new_item.appendChild(new_item_content);
 open_items.push(new_item);
 saveAndReload(open_items, done_items, list_name);
}


function getHighValue(the_document) {
 var high_number = 0;
 var this_number = 0;
 var items = the_document.getElementsByTagName("item");
 for (var loop = 0; loop < items.length; loop++) {
   this_number = parseInt(getFirstValue(items[loop], "number"));
   if (this_number > high_number) {
     high_number = this_number;
    }
  }
return high_number;
}


function readyDisplayList(list_name) {
 var file_name = list_name + ".xml";
 readFileDoFunction(file_name, "GET", function() {
   if (request.readyState == 4) {
   if (request.status == 200) {
   var last_modified = request.getResponseHeader("Last-Modified");
   var last_modified_date = new Date(last_modified);
   displayList(request.responseXML, last_modified_date.getTime());
    } 
    else {
     document.getElementById("errorDiv").innerHTML = "Sorry, could not display To Do list " + list_name +
      " due to a problem with the server.";
    }
   }
  }
 );
}


function displayList(the_list, last_modified_date) {
 var list_name = getFirstValue(the_list, "name");
 var intro_text = "<h4>Looking at list: " + list_name + "</h4>";
 var pending_display = "<h3>Still Pending:<br></h4><ul>";
 var open_item_element = the_list.getElementsByTagName("openitems")[0];
 var open_items = open_item_element.getElementsByTagName("item");
 for (var loop = 0; loop < open_items.length; loop++) {
   this_item = open_items[loop];
   this_contents = getFirstValue(this_item, "contents");
   this_number = getFirstValue(this_item, "number");
   pending_display += "<li id = 'pend_list'><input type='checkbox' " +
     "onClick=\"readyMarkDone('" + list_name + "'," +
   this_number + ");\"> " + this_contents;
  }
 pending_display += "</ul>";
 var done_display = "<h3>Completed:<br></h3><ul><del>";
 var open_item_element = the_list.getElementsByTagName("doneitems")[0];
 var open_items = open_item_element.getElementsByTagName("item");
 for (var loop = 0; loop < open_items.length; loop++) {
   this_item = open_items[loop];
   this_contents = getFirstValue(this_item, "contents");
   this_number = getFirstValue(this_item, "number");
   done_display += "<li id='completed'><input type='checkbox' " +
     "onClick=\"readyMarkUndone('" + list_name + "'," + this_number +
      ");\"> " + this_contents;
  }
 done_display += "</del></ul>";
 document.getElementById("contentArea").innerHTML = intro_text + pending_display + done_display;
 document.getElementById("contentArea").innerHTML +=
   "<p> <form><strong>Add New Item: </strong><input type='text' name='newItem'>" +
    "<input type=\"button\" value=\"add\" " +
    "onClick=\"addNewItem(this.form, '" + list_name + "');\"></form>";
  todo_list_timeout = setTimeout("updateTodoIfChanged(" + last_modified_date + ",'" +
  list_name + "')", seconds_between_todo_list_update);
 }
 
 
function getFirstValue(my_element, child) {
  return my_element.getElementsByTagName(child)[0].firstChild.nodeValue;
 }
 
 
function readyMarkDone(list_name, the_item) {
 var file_name = list_name + ".xml";
  readFileDoFunction(file_name, "GET", function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        markDone(request.responseXML, the_item, list_name);
       } 
      else {
       document.getElementById("errorDiv").innerHTML =
       "Sorry, this item could not be marked done due to a problem " +
       "with the server.";
      }
     }
   }
 );
}


function readyMarkUndone(list_name, the_item) {
 var file_name = list_name + ".xml";
 readFileDoFunction(file_name, "GET", function() {
   if (request.readyState == 4) {
   if (request.status == 200) {
     markUndone(request.responseXML, the_item, list_name);
    } 
   else {
    document.getElementById("errorDiv").innerHTML =
    "Sorry, this item could not be marked undone due to a problem " +
    "with the server.";
    }
   }
  }
 );
}


function markDone(the_document, the_item, list_name, last_modified_date) {
 var open_items = getItems(the_document,"openitems");
 var done_items = getItems(the_document,"doneitems");
 var this_number;
 var found_item = null;
 var count = 0;
 while ((count < open_items.length) && (found_item == null)) {
   this_number = getFirstValue(open_items[count], "number");
   if (this_number == the_item) {
     found_item = open_items[count];
    } 
   else {
    count++;
    }
  }
 if (found_item != null) {
   open_items.splice(count, 1);
   done_items.push(found_item);
   saveAndReload(open_items, done_items, list_name);
  }
}


function markUndone(the_document, the_item, list_name) {
 var open_items = getItems(the_document,"openitems");
 var done_items = getItems(the_document,"doneitems");
 var this_number;
 var found_item = null;
 var count = 0;
 while ((count < done_items.length) && (found_item == null)) {
   this_number = getFirstValue(done_items[count], "number");
   if (this_number == the_item) {
     found_item = done_items[count];
    } 
   else {
     count++;
    }
   }
 if (found_item != null) {
   done_items.splice(count, 1);
   open_items.push(found_item);
   saveAndReload(open_items, done_items, list_name);
  }
}


function getItems(the_document, the_item_type) {
 var the_items_array = new Array();
 var item_elements = the_document.getElementsByTagName(the_item_type)[0];
 var items = item_elements.getElementsByTagName("item");
 for (var loop = 0; loop < items.length; loop++) {
   the_items_array[loop] = items[loop];
  }
 return the_items_array;
}


function saveAndReload(open_items, done_items, list_name) {
 var the_string = "<?xml version='1.0' ?>";
 the_string += "<list>";
 the_string += "<name>" + list_name + "</name>";
 the_string += getItemString("openitems", open_items);
 the_string += getItemString("doneitems", done_items);
 the_string += "</list>";
 var file_name = list_name + ".xml";
 saveFileDoFunction(file_name, the_string, function() {
 if (request.readyState == 4) {
   if ((request.responseText == "success") && (request.status == 200)) {
     readyDisplayList(list_name);
    } 
   else {
    document.getElementById("errorDiv").innerHTML =
    "Sorry, there was an error saving your list. " +
    request.responseText;
    }
   }
 }
);
}


function getItemString(item_list_name, item_list) {
 var the_string = "<" + item_list_name + ">";
 for (var loop = 0; loop < item_list.length; loop++) {
   the_string += "<item>";
   the_string += "<number>" + getFirstValue(item_list[loop], "number") + "</number>";
   the_string += "<contents>" +
   getFirstValue(item_list[loop], "contents") + "</contents>";
   the_string += "</item>";
   }
 the_string += "</" + item_list_name + ">";
 return the_string;
}


function logout() {
 var the_date = new Date("December 31, 1900");
 var the_cookie_date = the_date.toGMTString();
 var user_name = getNameFromCookie();
 document.cookie = "user=" + escape(user_name) + ";expires=" + the_cookie_date;
 clearTimeout(user_list_timeout);
 clearTimeout(current_list_timeout);
 window.location.reload();
}


function getNameFromCookie() {
 var cookieParts = null;
 var user_name = null;
 if (document.cookie != null) {
  user_name = document.cookie.split("=")[1];
 }
 return user_name;
}


function checkIfLoggedIn() {
 var user_name = getNameFromCookie();
 if (user_name != null) {
     displayHomeInformation(user_name);
  }
}
