//alert("Hello, World!");

//prompt("What is your name?", "Type your name here");

function sayHello(name) {
  alert("Hello, " + name + "!");
}

function retrieveName() {
  const name = prompt("What is your name?", "Type your name here");
  sayHello(name);
  document.write("Your name is: " + name);
}

function windowParams() {
  var i = 0;
  for (prop in window.screen) {
    i++;
    document.write(i + ". ");
    document.write(prop + ": ");
    document.write(window[prop] + "<br><br>");

    //console.log(prop);
  }
}
document.addEventListener("DOMContentLoaded", () => {
  console.log(document.body);

  var h2 = document.querySelector("h2");
  console.log(h2);
  h2.textContent = "Hello, Luca!";

  var span = document.createElement("span");
  span.textContent = "This is a new span element.";
  document.body.appendChild(span);
});