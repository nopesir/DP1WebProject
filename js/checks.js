/** This file is responsible for managing client-side controls. **/

// Check the registration values in the Sign-in form
function checkRegistrationValues() {
  var user = document.getElementById("Username").value;
  var pwd = document.getElementById("PassSignin").value;
  var conf_pwd = document.getElementById("ConfirmPassword").value;
  var regexres = pwd.match(/^(?=.*[a-z])(?=.*[A-Z\d]).+$/);

  if ((user === "") || (pwd === "") || (conf_pwd === "")) {
    window.alert("You miss a field! Please fill it before send your request!");
    return false;
  } else {
    if (checkPassword() && regexres)
      return true;
    else {
      if (!regexres) {
        window.alert("Password not valid, check the NOTE below!");
      } else {
        window.alert("The password and the confirmation password must match! Please check it!");
      }
      return false;
    }
  }
}

// Check the login in the login prompt
function checkLoginValues() {
  var user = document.getElementById("Username").value;
  var pwd = document.getElementById("LoginPassword").value;
  
  if ((user === "") || (pwd === "")) {
    window.alert("You miss something! Please fill it!");
    return false;
  } else
    return true;
}

// Check the registration passwords in the Sign-in form
function checkPassword() {
  var pwd1 = document.getElementById("PassSignin").value;
  var pwd2 = document.getElementById("ConfirmPassword").value;
  var text = document.getElementById("textpwd");

  var toRet;
  if (pwd1 === pwd2) {
    text.setAttribute("class", "greenalert");
    text.innerHTML = "Passwords corresponding!"
    toRet = true;
  } else {
    text.setAttribute("class", "redalert");
    text.innerHTML = "Passwords not corresponding!"
    toRet = false;
  }
  text.style.visibility = "visible";
  return toRet;
}

// Check the reservation number of passengers in the Book form
function checkNPass(num) {
  var nPass = document.getElementById("TextNPass").value;
  var text = document.getElementById("textpwd-2");

  var toRet;
  if ((nPass > 0) && (nPass <= num)) {
    text.innerHTML = "";
    toRet = true;
  } else {
    text.setAttribute("class", "yellowalert");
    text.innerHTML = "MIN 1 and MAX " + num;
    toRet = false;
  }
  text.style.visibility = "visible";
  return toRet;
}

// Check the reservation dep and dest in the Book form
function checkDest() {
  var dep = document.getElementById("TextDep").value;
  var dest = document.getElementById("TextDest").value;
  var text = document.getElementById("textpwd-3");

  var toRet;
  if (dest.localeCompare(dep) == 1) {
    text.innerHTML = "";
    toRet = true;
  } else {
    text.setAttribute("class", "redalert");
    text.innerHTML = "Destination must be AFTER Departure!";
    toRet = false;
  }
  text.style.visibility = "visible";
  return toRet;
}