// ================================
// DARK MODE
// ================================

const darkButton = document.querySelector(".btn-light");

darkButton.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");

    if(document.body.classList.contains("dark-mode")){
        darkButton.innerHTML = '<i class="fa-solid fa-sun"></i>';
    }
    else{
        darkButton.innerHTML = '<i class="fa-solid fa-moon"></i>';
    }
});


// ================================
// SMOOTH SCROLLING
// ================================

document.querySelectorAll('a[href^="#"]').forEach(anchor => {

    anchor.addEventListener("click", function(e){

        e.preventDefault();

        const target = document.querySelector(this.getAttribute("href"));

        if(target){
            target.scrollIntoView({
                behavior:"smooth"
            });
        }

    });

});


// ================================
// SEARCH BUTTON
// ================================

const searchButton = document.querySelector(".card button");

searchButton.addEventListener("click", function(e){

    e.preventDefault();

    const rollNumber = document.querySelector("input").value.trim();

    if(rollNumber === ""){

        alert("Please enter your Roll Number.");

    }

    else{

        alert("Searching Result for Roll Number : " + rollNumber);

        // Backend will be connected later

    }

});


// ================================
// CARD HOVER ANIMATION
// ================================

const cards = document.querySelectorAll(".card");

cards.forEach(card=>{

    card.addEventListener("mouseenter",()=>{

        card.style.transform="translateY(-10px)";

    });

    card.addEventListener("mouseleave",()=>{

        card.style.transform="translateY(0px)";

    });

});


// ================================
// WELCOME MESSAGE
// ================================

window.onload = function(){

    console.log("Welcome to Student Result Viewer");

}


// ================================
// BACK TO TOP BUTTON
// ================================

// Create Button

const topButton = document.createElement("button");

topButton.innerHTML = '<i class="fa-solid fa-arrow-up"></i>';

topButton.id = "topButton";

document.body.appendChild(topButton);


// Button Style

topButton.style.position = "fixed";
topButton.style.bottom = "30px";
topButton.style.right = "30px";
topButton.style.width = "50px";
topButton.style.height = "50px";
topButton.style.borderRadius = "50%";
topButton.style.border = "none";
topButton.style.background = "#1565c0";
topButton.style.color = "white";
topButton.style.cursor = "pointer";
topButton.style.display = "none";
topButton.style.fontSize = "20px";
topButton.style.boxShadow = "0 5px 15px rgba(0,0,0,.3)";


// Show Button

window.addEventListener("scroll",()=>{

    if(window.scrollY > 300){

        topButton.style.display = "block";

    }

    else{

        topButton.style.display = "none";

    }

});


// Scroll Top

topButton.addEventListener("click",()=>{

    window.scrollTo({

        top:0,
        behavior:"smooth"

    });

});