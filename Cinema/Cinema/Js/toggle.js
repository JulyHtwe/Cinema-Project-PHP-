var detailDiv = document.getElementById("for_detail");
var ratingDiv = document.getElementById("for_rating");
var detailBtn = document.getElementById("detail_btn"); // Fixed spelling
var ratingBtn = document.getElementById("rating_btn");

// Click event for Details button
detailBtn.addEventListener("click", function () {
    detailBtn.classList.add('active-btn');
    ratingBtn.classList.remove('active-btn');
    detailDiv.style.display = "block";
    ratingDiv.style.display = "none";
});

// Click event for Rating button
ratingBtn.addEventListener("click", function () {
    ratingBtn.classList.add('active-btn');
    detailBtn.classList.remove('active-btn');
    detailDiv.style.display = "none";
    ratingDiv.style.display = "block";
});

// YouTube trailer button
// document.getElementById("trailer_btn").addEventListener("click", function () {
//     if (youtubeUrl) {
//         window.location.href = youtubeUrl; // Redirect to YouTube URL
//     } else {
//         alert("No YouTube URL available!");
//     }
// });
