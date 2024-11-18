// Mengambil semua elemen dengan kelas "input"
const inputs = document.querySelectorAll(".input");

// Fungsi untuk menambahkan kelas "focus" ke elemen parent saat input mendapatkan fokus
function addcl() {
  let parent = this.parentNode.parentNode;
  parent.classList.add("focus");
}

// Fungsi untuk menghapus kelas "focus" dari elemen parent jika input kosong saat kehilangan fokus
function remcl() {
  let parent = this.parentNode.parentNode;
  if (this.value == "") {
    parent.classList.remove("focus");
  }
}

// Menambahkan event listener untuk event "focus" dan "blur" ke setiap elemen input
inputs.forEach((input) => {
  input.addEventListener("focus", addcl); // Menambahkan kelas "focus" saat input mendapatkan fokus
  input.addEventListener("blur", remcl); // Menghapus kelas "focus" saat input kehilangan fokus
});

// Mengambil elemen dengan kelas "bxs-hide" (ikon untuk menunjukkan/smeymbunyikan password)
const hidePass = document.querySelector(".bxs-hide");

// Mengambil elemen input dengan tipe password
const inputPass = document.querySelector('input[type="password"]');

// Menambahkan event listener untuk klik pada ikon untuk toggle visibilitas password
hidePass.addEventListener("click", () => {
  hidePass.classList.toggle("bxs-show"); // Toggle kelas "bxs-show" pada ikon
  const type =
    inputPass.getAttribute("type") === "password" ? "text" : "password";
  inputPass.setAttribute("type", type); // Toggle tipe input antara "text" dan "password"
});
