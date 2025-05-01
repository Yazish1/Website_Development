// Set a cookie with SameSite and Secure for HTTPS
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    const secure = location.protocol === "https:" ? ";Secure" : "";
    document.cookie = `${name}=${value};${expires};path=/;SameSite=Lax${secure}`;
  }
  
  // Get a cookie by name
  function getCookie(name) {
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');
    name = name + "=";
    for (let c of cookies) {
      c = c.trim();
      if (c.indexOf(name) === 0) return c.substring(name.length);
    }
    return "";
  }
  
  // Show greeting on the page
  function showGreeting(name) {
    const greetingDiv = document.getElementById("greeting");
    if (greetingDiv) {
      greetingDiv.textContent = `Welcome back, ${name}!`;
    }
  }
  
  // Save name to cookie and update greeting
  function setName() {
    const nameInput = document.getElementById("nameInput");
    if (nameInput) {
      const name = nameInput.value.trim();
      if (name) {
        setCookie("username", name, 7);
        showGreeting(name);
      }
    }
  }
  
  // Clear the saved cookie and greeting
  function clearName() {
    setCookie("username", "", -1); // Expire immediately
    const greetingDiv = document.getElementById("greeting");
    if (greetingDiv) {
      greetingDiv.textContent = "";
    }
  }
  
  // On page load, greet user if cookie exists
  window.onload = function () {
    const savedName = getCookie("username");
    if (savedName) {
      showGreeting(savedName);
    }
  };
  