
(function () {
  "use strict";

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll(".needs-validation");

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();
/////// For direction website when you selection the language


function toggleBankFields() {
  const payMethod = document.getElementById("PayMethod").value;
  const bankField = document.getElementById("BankField");
  const transferImageField = document.getElementById("TransferImageField");

  // إخفاء الحقول في البداية
  bankField.style.display = "none";
  transferImageField.style.display = "none";

  // تحقق من القيمة وإذا كانت 3 أو 6، أظهر الحقول
  if (payMethod == "3" || payMethod == "6") {
    bankField.style.display = "block";
    transferImageField.style.display = "block";
  }
}

console.log(document.querySelector("html").dir);
