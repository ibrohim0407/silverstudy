const currentDate = new Date();
const year = currentDate.getFullYear(); 
const month = currentDate.getMonth() + 1;

const day = currentDate.getDate(); 

window.addEventListener("load", function() {
    // 2 soniya kutish
    setTimeout(function() {
      // Yuklash ekranini yashirish
      document.getElementById("loading").style.display = "none";
      // Asosiy kontentni ko'rsatish
      document.getElementById("content").style.display = "block";
    }, 350); // 2000 millisekund = 2 soniya
    document.getElementById("yilayir").textContent=`${year-2024+1} Yil tajribasi`;
});