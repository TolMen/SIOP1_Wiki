document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");

    searchInput.addEventListener("input", function () {
        const query = this.value.trim();
        searchResults.innerHTML = "";

        if (query.length === 0) return;

        fetch(
            `src/control/SearchControl/searchLive.php?q=${encodeURIComponent(
                query
            )}`
        )
            .then((response) => response.json())
            .then((data) => {
                data.slice(0, 5).forEach((article) => {
                    const li = document.createElement("li");
                    li.className = "list-group-item list-group-item-action";
                    li.textContent = article.title;
                    li.onclick = () => {
                        window.location.href = `templateArt.php?articleID=${article.id}`;
                    };
                    searchResults.appendChild(li);
                });
            });
    });

    document.addEventListener("click", function (e) {
        if (
            !searchInput.contains(e.target) &&
            !searchResults.contains(e.target)
        ) {
            searchResults.innerHTML = "";
        }
    });
});
