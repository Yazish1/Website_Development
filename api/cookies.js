// --- Your cookie helper functions ---

function setCookie(name, value, days) {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = name + "=" + encodeURIComponent(value) + "; expires=" + expires + "; path=/";
  }
  
  function getCookie(name) {
    return document.cookie.split("; ").reduce((r, v) => {
      const parts = v.split("=");
      return parts[0] === name ? decodeURIComponent(parts[1]) : r;
    }, "");
  }
  
  function deleteCookie(name) {
    setCookie(name, "", -1);
  }
  
  function showGreeting(name) {
    document.getElementById("greeting").innerText = `Hello, ${name}!`;
  }
  
  function setName() {
    const name = document.getElementById("nameInput")?.value;
    if (name) {
      setCookie("username", name, 7);
      showGreeting(name);
    }
  }
  
  function clearName() {
    deleteCookie("username");
    document.getElementById("greeting").innerText = "";
  }
  
  // --- ✅ THIS PART GOES AT THE END ---
  window.onload = function () {
    const savedName = getCookie("username");
    if (savedName) {
      showGreeting(savedName);
    }
  
    document.getElementById("saveBtn")?.addEventListener("click", setName);
    document.getElementById("resetBtn")?.addEventListener("click", clearName);
  };
  