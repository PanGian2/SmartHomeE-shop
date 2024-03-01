const input = document.getElementById("searchInput");
const searchForm = document.getElementById("search");
const div = document.getElementById("searchResults")
let filters = {}
let filteredResults = [];

//when DOM is loaded get the search filters
document.addEventListener("DOMContentLoaded", event => {

    let xhr = new XMLHttpRequest();
    xhr.open("GET", source + "product.php?getFilters=true", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const response = JSON.parse(xhr.responseText);

            //for each item in the response
            response.forEach(function (item) {
                //get the key
                let key = Object.keys(item)[0];
                if (item[key] !== null && item[key] !== undefined) {
                    if (!Array.isArray(filters[key])) {
                        filters[key] = [];
                    }
                    //push data to the corresponding key
                    filters[key].push(item[key]);
                }
            });

        }
    }
    xhr.send();


})

//check if user clicks in or out of the search list
document.addEventListener('click', event => {
    const ul = document.getElementById("searchList");
    //if the user clicked out of list, clear it's content
    if (!ul.contains(event.target) && event.target !== input) {
        ul.innerHTML = ''
    }
});

if (input != null) {
    //while user is typing
    input.addEventListener("keyup", event => {
        let searchInput = input.value;
        const ul = document.getElementById("searchList");

        filteredResults = [];
        //return all data from filters that match the user's input
        Object.entries(filters).forEach(function ([key, items]) {
            items.forEach(function (item) {
                if (item && item.toLowerCase().includes(searchInput.toLowerCase())) {
                    filteredResults.push({ key: key, value: item });
                }
            });
        });
        ul.innerHTML = '';
        //populate the list with the results
        filteredResults.forEach(function (result) {
            let li = document.createElement('li');
            let a = document.createElement('a');
            li.setAttribute("class", "list-group-item")
            a.textContent = result.value;
            a.href = views + 'products/product_list.php?' + result.key + "=" + result.value;
            li.appendChild(a);
            searchList.appendChild(li);
        });
    })
}


if (searchForm != null) {

    //when search is submitted, redirect user
    searchForm.addEventListener("submit", event => {
        let path, query, value;
        event.preventDefault();
        //to the first reussult of the list
        if (typeof filteredResults[0] != "undefined") {
            result = filteredResults[0];
            path = views + 'products/product_list.php?' + result.key + "=" + result.value;
            query = result.key;
            value = result.value;
            console.log(value)
            input.setAttribute("name", query)
            input.setAttribute("value", value);
        } else {
            //or to all products
            path = views + 'products/product_list.php';
            value = "all"
            input.setAttribute("value", value);
        }
        window.location.href = path;
    })
}
