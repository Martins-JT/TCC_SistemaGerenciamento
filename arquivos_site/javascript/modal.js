document.addEventListener('DOMContentLoaded', () => {
    // 1. Selecionar todos os botões que abrem o modal
    const visualizarBtns = document.querySelectorAll('.btn-visualizar');
    
    // 2. Selecionar o container do modal e o corpo do modal
    const modalContainer = document.getElementById('modal-produto');
    const modalBody = modalContainer.querySelector('.modal-body');
    const modalTitle = modalContainer.querySelector('.modal-title');
    
    // 3. Selecionar todos os botões de fechar
    const closeBtn1 = document.querySelectorAll('.close-modal');
    const closeBtn2 = document.querySelectorAll('.btn-fechar');

    // 4. Adicionar um evento de clique para cada botão "Visualizar"
    visualizarBtns.forEach(btn => {
        btn.addEventListener('click', (event) => {
            const productIndex = event.target.getAttribute('data-product-index');
            const produto = produtosData[productIndex];

            // Injetar o título do modal
            modalTitle.textContent = `Detalhes do Fornecedor - ${produto.produto}`;

            // Lógica para injetar todos os dados no corpo do modal
            modalBody.innerHTML = `
                <p><strong>Fornecedor:</strong> ${produto.NOME_EMPRESA}</p>
                <p><strong>Nome do Produto:</strong> ${produto.produto}</p>
                <p><strong>Categoria:</strong> ${produto.categoria}</p>
                <p><strong>Valor:</strong> R$ ${parseFloat(produto.valor).toFixed(2).replace('.', ',')}</p>
                <p><strong>Descrição:</strong> ${produto.descricao}</p>
                <p><strong>CNPJ:</strong> ${produto.CNPJ}</p>
                <p><strong>Email:</strong> ${produto.EMAIL}</p>
                <p><strong>Telefone:</strong> ${produto.TELEFONE}</p>
                <p><strong>Endereço:</strong> ${produto.RUA}, ${produto.NUMERO} - ${produto.CIDADE} - ${produto.ESTADO}, ${produto.CEP}</p>
            `;

            // Exibir o modal
            modalContainer.style.display = 'flex';
        });
    });

    // 5. Adicionar evento de clique para fechar o modal
    closeBtn1.forEach(btn => {
        btn.addEventListener('click', () => {
            modalContainer.style.display = 'none';
        });
    });
     closeBtn2.forEach(btn => {
        btn.addEventListener('click', () => {
            modalContainer.style.display = 'none';
        });
    });

    // 6. Fechar o modal se o usuário clicar fora dele
    window.addEventListener('click', (event) => {
        if (event.target == modalContainer) {
            modalContainer.style.display = 'none';
        }
    });
});