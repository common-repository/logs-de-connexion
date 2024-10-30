document.addEventListener("DOMContentLoaded", () => {
	if (document.querySelector("#WPLogs_table")) {
		function filterTable(column, searchValue) {
			var table = document.querySelector("#WPLogs_table");
			var rows = table.querySelectorAll("tbody tr");

			for (var i = 0; i < rows.length; i++) {
				var cells = rows[i].querySelectorAll("td");
				var cellValue = cells[column].textContent || cells[column].innerText;

				if (cellValue.toLowerCase().includes(searchValue.toLowerCase())) {
					rows[i].style.display = "";
				} else {
					rows[i].style.display = "none";
				}
			}
		}

		document.querySelector("#WPLogs_filter_select").addEventListener("change", updateFilter);
		document.querySelector("#WPLogs_filter_searchBar").addEventListener("input", updateFilter);

		function updateFilter() {
			var selectedColumn = document.querySelector("#WPLogs_filter_select").value;
			var searchValue = document.querySelector("#WPLogs_filter_searchBar").value;

			if (selectedColumn === "WPLogs_ID") {
				filterTable(0, searchValue);
			} else if (selectedColumn === "WPLogs_MemberID") {
				filterTable(1, searchValue);
			} else if (selectedColumn === "WPLogs_names") {
				filterTable(2, searchValue);
			} else if (selectedColumn === "WPLogs_URL") {
				filterTable(3, searchValue);
			} else if (selectedColumn === "WPLogs_timeIN") {
				filterTable(4, searchValue);
			} else if (selectedColumn === "WPLogs_timeOUT") {
				filterTable(5, searchValue);
			} else if (selectedColumn === "WPLogs_duration") {
				filterTable(6, searchValue);
			} else if (selectedColumn === "WPLogs_timer") {
				filterTable(7, searchValue);
			}
		}

		let refreshButton = document.querySelector("#WPLogs_refresh");
		refreshButton.addEventListener("click", () => {
			location.reload();
		});
	}
});
