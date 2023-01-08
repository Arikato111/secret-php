function getLike(post_id) {
  let data = { post: post_id };
  fetch("/api/like", {
    method: "POST",
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((data) => {
      const likeCount = document.getElementById(`likecount${post_id}`);
      if (data.isLike) {
        document.getElementById(`like${post_id}`).style.display = "none";
        document.getElementById(`liked${post_id}`).style.display =
          "inline-block";
        likeCount.innerText = Math.floor(likeCount.innerText) + 1;
      } else {
        document.getElementById(`like${post_id}`).style.display =
          "inline-block";
        document.getElementById(`liked${post_id}`).style.display = "none";
        likeCount.innerText = Math.floor(likeCount.innerText) - 1;
      }
    });
}
