<?php
include "action.php";
include "header.php";
backToMainPage();
$category_name = $_GET['category'];
$findSameCategories = findSameCategories($sameCategories = [], $category_name);
$page = $_GET['page'];
$fragmentLen = 5;
$numPages = ceil(count($findSameCategories) / $fragmentLen);
output($findSameCategories, $page, $fragmentLen);
echo '<div class="container d-flex justify-content-center mt-3">';
echo "<ul class='pagination'>";
($page - 1) < 0
    ?
    $strElements = [$page, "Prev"]
    :
    $strElements = [$page - 1, "Prev"];
echo "<li class='page-item'><a class='page-link' href='category.php?category=".$category_name."&page=" . $strElements[0] . "'>" . $strElements[1] . "</a></li>";

for ($i = 0; $i < $numPages; $i++) {
    echo "<li class='page-item'><a class='page-link' href='category.php?category=".$category_name."&page=" . $i . "'>" . $i + 1 . "</a></li>";
}

($page + 1) > ($numPages - 1)
    ?
    $strElements = [$page, "Next"]
    :
    $strElements = [$page + 1, "Next"];

    echo "<li class='page-item'><a class='page-link' href='category.php?category=".$category_name."&page=" . $strElements[0] . "'>" . $strElements[1] . "</a></li>";
echo "</ul>";
echo "</div>";

include "footer.php";