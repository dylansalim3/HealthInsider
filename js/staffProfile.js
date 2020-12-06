const url = "./php/staff_profile_update.php";
let options = {
  method: "post",
  header: new Headers(),
  body: ""
};
let form = document.getElementById("form");
document.querySelector("#submit").addEventListener("click", event => {
  event.preventDefault();
  let formData = new FormData(document.querySelector("form"));
  checkPassword(
    document.getElementById("oldName").innerHTML,
    formData.get("oldPassword")
  );
});

function checkPassword(oldName, password) {
  let formData = new FormData();

  formData.append("oldName", oldName);
  formData.append("password", password);
  options.body = formData;

  fetch(url, options)
    .then(res => res.json())
    .then(passwordBoolean => {
      console.log("checkpassword   " + passwordBoolean);
      if (passwordBoolean) {
        console.log('yess');
        update(passwordBoolean);
      } else {
        console.log('noo');
        showError("pw2");
      }
    });
}

function update(passwordBoolean) {
  if (!passwordBoolean) {
    showError("pw2");
    console.log('tf');
    return;
  }

  let formData = new FormData(document.querySelector("form"));
  if (formData.get("password") !== formData.get("password2")) {
    showError("pw");
    return;
  }
  post(formData);
}

function post(formData) {
  formData.append("oldName", document.getElementById("oldName").innerHTML);
  options.body = formData;
  console.log(options.body);
  fetch(url, options)
    .then(res => res.text())
    .then(data => {
      console.log(data);
      showSuccess();
    });
}

function showSuccess() {
  if (window.location.href.match(/success/gi)) {
    location.reload();
  }
  window.location.replace("?success#alert");
}

function showError(errorType) {
  let alertDiv = document.getElementById("alert");
  if (errorType === "pw") {
    alertDiv.innerHTML = "Please retype your new password";
    alertDiv.classList.add("alert-danger");
    alertDiv.style.display = "";
    window.location.replace("#newPassword");
  } else if (errorType === "pw2") {
    alertDiv.innerHTML = "Your password is wrong";
    alertDiv.classList.add("alert-danger");
    alertDiv.style.display = "";
    window.location.replace("#oldPassword");
  }
}
