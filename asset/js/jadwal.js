document.querySelectorAll(".hapus").forEach(btn => {
    btn.addEventListener("click", function(e) {
        e.preventDefault();
        const link = this.href;

        const confirmBox = document.createElement("div");
        confirmBox.innerHTML = `
            <div style="
                position:fixed;
                top:0;left:0;
                width:100%;
                height:100%;
                background:rgba(0,0,0,0.6);
                display:flex;
                justify-content:center;
                align-items:center;
                z-index:9999;">
                <div style="
                    background:#1c1c2e;
                    padding:30px;
                    border-radius:20px;
                    text-align:center;
                    color:white;
                    box-shadow:0 0 30px rgba(0,245,255,0.4);">
                    <h3>Yakin mau hapus?</h3>
                    <br>
                    <button id="yesDel" style="margin:5px;padding:10px 20px;border:none;border-radius:10px;background:#ff3cac;color:white;">Ya</button>
                    <button id="noDel" style="margin:5px;padding:10px 20px;border:none;border-radius:10px;background:#555;color:white;">Batal</button>
                </div>
            </div>
        `;
        document.body.appendChild(confirmBox);

        document.getElementById("yesDel").onclick = () => {
            window.location.href = link;
        };

        document.getElementById("noDel").onclick = () => {
            confirmBox.remove();
        };
    });
});