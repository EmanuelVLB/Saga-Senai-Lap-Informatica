// Configurando menu pequeno
{
  let bt_menu = window.document.querySelector(".--menuToggle");
  let menu_ativo = window.document.querySelector(".--activeMenu");
  let contador = 0;
  
  bt_menu.addEventListener("click", function () {
    if (contador == 0) {
      menu_ativo.style.display = "block";
      contador++;
    } else {
      menu_ativo.style.display = "none";
      contador -= 1;
    }
  });
}