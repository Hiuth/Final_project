var sortMemory = {};

function sortTable(n, type) {
  var table = document.getElementById("table");
  var swap = true;
  var shouldSwap;
  if (!sortMemory[n]) {
    sortMemory[n] = "asc";
  }

  sort = sortMemory[n];
  var rows = table.getElementsByTagName("TR");

  while (swap) {
    swap = false;
    for (var i = 1; i < rows.length - 1; i++) {
      shouldSwap = false;
      var rowTop = rows[i].getElementsByTagName("TD")[n];
      var rowBelow = rows[i + 1].getElementsByTagName("TD")[n];
      var rowTopValue, rowBelowValue;

      if (type === "number") {
        var top = rowTop.querySelector(".price").innerText;
        rowTopValue = parseInt(top.replace(/\./g, ""), 10);
        var below = rowBelow.querySelector(".price").innerText;
        rowBelowValue = parseInt(below.replace(/\./g, ""), 10);
      } else if (type === "string") {
        rowTopValue = rowTop.innerHTML.toLowerCase();
        rowBelowValue = rowBelow.innerHTML.toLowerCase();
      } else if (type === "date") {
        rowTopValue = new Date(rowTop.innerText);
        rowBelowValue = new Date(rowBelow.innerText);
      }

      if (
        (sort === "asc" && rowTopValue > rowBelowValue) ||
        (sort === "desc" && rowTopValue < rowBelowValue)
      ) {
        shouldSwap = true;
        break;
      }
    }

    if (shouldSwap) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      swap = true;
    }

    if (!shouldSwap && sort === "asc") {
      sortMemory[n] = "desc";
    } else if (!shouldSwap && sort === "desc") {
      sortMemory[n] = "asc";
    }
  }
}
