function editarInformacoes() {
  // Mostrar o formulário de edição
  document.getElementById('form-edit').style.display = 'flex';

  // Esconder todas as divs com a classe comum
  document.querySelectorAll('.informs-info').forEach(el => {
    el.style.display = 'none';
  });
}


    //document.getElementById('informs-info').style.display = 'none';
   // document.getElementById('informs-info2').style.display = 'none';

 
  function salvarEdit() {
  const produto = document.getElementById('produtoInput').value;
  const quantidade = document.getElementById('quantidadeInput').value;

  document.getElementById('produto').textContent = produto;
  document.getElementById('quantidade').textContent = `${quantidade} unidades`;

  const dataAtual = new Date();
  const horaAtual = dataAtual.toLocaleString('pt-BR', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
    hour: '2-digit', minute: '2-digit', second: '2-digit'
  });
  document.getElementById('ultimaAtualizacao').textContent = horaAtual;

  // Esconder o formulário e mostrar os elementos informativos
  document.getElementById('form-edit').style.display = 'none';

  document.querySelectorAll('.informs-info').forEach(el => {
    el.style.display = 'flex';
  });
}

  
  // Função para cancelar a edição
  function cancelarEdit() {
  document.getElementById('form-edit').style.display = 'none';

  document.querySelectorAll('.informs-info').forEach(el => {
    el.style.display = 'flex';
  });
}

  

  