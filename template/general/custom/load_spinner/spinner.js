let spinner = `<div id="page-preloader" style="background: rgba(0, 0, 0, 0.3);">
      <span class="spinner"></span>
    </div>`;
document.body.insertAdjacentHTML("afterbegin", spinner);

document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function (){
        document.getElementById("page-preloader").style.display = "none";
    }, 100)
});
