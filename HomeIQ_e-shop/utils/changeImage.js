//change the source of the mainImage img
function changeImage(newImageUrl) {
    document.getElementById('mainImage').src = newImageUrl;
}

function getImgHeight() {
    const height = document.getElementById('mainImage').offsetHeight;
    console.log(height)
}