// Functionality for Search Button
function handleSearch() {
    const query = document.getElementById('search-input').value;
    if (query.trim() === '') {
        alert('Please enter a search term!');
    } else {
        window.location.href = `search.html?query=${encodeURIComponent(query)}`;
    }
  }
  