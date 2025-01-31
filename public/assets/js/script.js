// Handle the search with ajax

document.querySelector("#search-bar").addEventListener("keyup", function () {
  let keyword = this.value.trim();

  if (keyword.length > 0) {
    let xhr = new XMLHttpRequest();
    let url = "../handlers/search.php?keyword=" + encodeURIComponent(keyword);

    //   console.log("Requesting:", url);

    xhr.open("GET", url, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        let articles = JSON.parse(xhr.responseText);
        console.log("Articles: ", articles);
        renderArticles(articles);
      } else {
        console.error("Error: ", xhr.status, xhr.statusText);
      }
    };
    xhr.send();
  } else {
    loadAllArticles();
  }
});

function loadAllArticles() {
  let xhr = new XMLHttpRequest();
  let url = "../handlers/search.php?keyword="; 

  xhr.open("GET", url, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      let articles = JSON.parse(xhr.responseText);
      console.log("All Articles: ", articles);
      renderArticles(articles); 
    } else {
      console.error("Error: ", xhr.status, xhr.statusText);
    }
  };
  xhr.send();
}

// function to render articles
function renderArticles(articles) {
  let articlesCont = document.querySelector("#search-results");
  console.log(articlesCont);
  articlesCont.innerHTML = "";

  if (articles.length === 0) {
    articlesCont.innerHTML = '<h2 class="text-center">No Articles Found</h2>';
    return;
  }
  console.log(articles);

  let html =
    '<div class="container my-5"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">';

  articles.forEach((article) => {
    html += `
          <div class="col">
              <div class="card article-card h-100">
                  <img src="../public/assets/img/${
                    article.featured_image
                  }" class="card-img-top" alt="Article Image">
                  <div class="card-body">
                      <h5 class="card-title">${article.title}</h5>
                      <p class="card-text">${article.content.substring(
                        0,
                        100
                      )}...</p>
                      <div class="d-flex justify-content-between align-items-center">
                          <small class="text-muted">${
                            article.author_name
                          }</small>
                          <small class="text-muted">${
                            article.created_at
                          }</small>
                      </div>
                      <a href="../views/singlePageArticle.php?id=${
                        article.id
                      }" class="btn btn-primary mt-3">Read More</a>
                  </div>
              </div>
          </div>
      `;
  });

  html += "</div></div>";
  articlesCont.innerHTML = html;
}


document.addEventListener("DOMContentLoaded", function () {
  loadAllArticles(); // Load all articles when the page loads
});