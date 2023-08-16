<!DOCTYPE html>
<head>


<link rel="stylesheet" href="style.css">
</head>

<h1>10 Dropdown Animations</h1>

<div  class="menu-container">
  <h3>Animate the Whole Menu</h3>
  <nav>
  <ul class="menu">
    <li class="dropdown dropdown-6">
      Scale Down
      <ul class="dropdown_menu dropdown_menu--animated dropdown_menu-6">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
     <li class="dropdown dropdown-7">
      RotateX
      <ul class="dropdown_menu dropdown_menu--animated dropdown_menu-7">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
    <li class="dropdown dropdown-8">
      TranslateZ
      <ul class="dropdown_menu dropdown_menu--animated dropdown_menu-8">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
    <li class="dropdown dropdown-9">
      Scale
      <ul class="dropdown_menu dropdown_menu--animated dropdown_menu-9">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
    <li class="dropdown dropdown-10">
      Rotate Y
      <ul class="dropdown_menu dropdown_menu--animated dropdown_menu-10">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
    
  </ul>
</nav>
</div>



<div class="menu-container">
  <h3>Animate Each Menu Items</h3>
<nav>
  <ul class="menu">
    <li class="dropdown dropdown-1">
      TranslateY
 	<ul class="dropdown_menu dropdown_menu-1">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
     <li class="dropdown dropdown-2">
      RotateX
      <ul class="dropdown_menu dropdown_menu-2">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
    <li class="dropdown dropdown-3">
      TranslateZ
      <ul class="dropdown_menu dropdown_menu-3">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
    <li class="dropdown dropdown-4">
      Scale
      <ul class="dropdown_menu dropdown_menu-4">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
    <li class="dropdown dropdown-5">
      TranslateX
      <ul class="dropdown_menu dropdown_menu-5">
        <li class="dropdown_item-1">Item 1</li>
        <li class="dropdown_item-2">Item 2</li>
        <li class="dropdown_item-3">Item 3</li>
          <li class="dropdown_item-4">Item 4</li>
          <li class="dropdown_item-5">Item 5</li>
      </ul>
    </li>
    
  </ul>
</nav>
</div>
<body>

<script>
// Mendapatkan elemen dropdown_menu-1
const dropdownMenu1 = document.querySelector('.dropdown_menu-1');

// Loop untuk membuat elemen dropdown_item-{num}
for (let num = 1; num <= 5; num++) {
  // Membuat elemen li
  const listItem = document.createElement('li');
  listItem.className = `dropdown_item-${num}`;
  listItem.style.transformOrigin = 'top center';
  listItem.style.animation = `slideDown 300ms ${num * 60}ms ease-in-out forwards`;

  // Menambahkan teks ke dalam elemen li
  const listItemText = document.createTextNode(`Dropdown Item ${num}`);
  listItem.appendChild(listItemText);

  // Menambahkan elemen li ke dalam dropdown_menu-1
  dropdownMenu1.appendChild(listItem);
}

// Menambahkan keyframes slideDown ke dalam stylesheet
const styleSheet = document.styleSheets[0];
styleSheet.insertRule(`
  @keyframes slideDown {
    0% {
      opacity: 0;
      transform: translateY(-60px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }
`, styleSheet.cssRules.length);


</script>
</body>
</html>
