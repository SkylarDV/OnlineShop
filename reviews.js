document.querySelector("#btnAddReview").addEventListener("click", function(e){

    let product_id = this.dataset.product_id;
    let user_id = this.dataset.user_id;
    let text = document.querySelector("#commentText").value;
    let rating = document.querySelector('input[name="rating"]:checked').value;
    console.log(text);
    console.log(rating);
    
    let formData = new FormData();
    formData.append("rating", rating);
    formData.append("text", text);
    formData.append("product_id", product_id);
    formData.append("user_id", user_id);
    console.log(formData);

    fetch("saveReview.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        let newReview = document.createElement('div');
        let r = document.createElement('h2');
        let t = document.createElement('p');
        r.innerHTML = result.rating;
        t.innerHTML = result.text;

        newReview.appendChild(r);
        newReview.appendChild(t);
        newReview.setAttribute("class", "reviewMsg");

        document.querySelector(".reviewMsgs").appendChild(newReview);
    })
    .catch(error => {console.error("Error:", error);})
});
