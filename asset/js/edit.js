const form = document.getElementById("formJadwal");
const button = document.querySelector("button");

form.addEventListener("submit", function(e) {
    const jamMulai = document.querySelector("input[name='jam_mulai']").value;
    const jamSelesai = document.querySelector("input[name='jam_selesai']").value;

    if (jamMulai >= jamSelesai) {
        e.preventDefault();
        showToast("Jam selesai harus lebih besar dari jam mulai!");
    }
});

/* Toast Modern */
function showToast(message) {
    const toast = document.createElement("div");
    toast.innerText = message;
    toast.style.position = "fixed";
    toast.style.top = "30px";
    toast.style.right = "30px";
    toast.style.background = "linear-gradient(45deg,#ff3cac,#784ba0)";
    toast.style.padding = "15px 25px";
    toast.style.borderRadius = "12px";
    toast.style.color = "white";
    toast.style.boxShadow = "0 10px 30px rgba(0,0,0,0.4)";
    toast.style.animation = "fadeSlide 0.5s ease";
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

/* Ripple Button Effect */
button.addEventListener("click", function(e) {
    const circle = document.createElement("span");
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;

    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${e.clientX - button.offsetLeft - radius}px`;
    circle.style.top = `${e.clientY - button.offsetTop - radius}px`;

    button.appendChild(circle);

    setTimeout(() => circle.remove(), 600);
});