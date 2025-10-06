document.addEventListener('DOMContentLoaded', () => {
    // Seleciona todos os botões que abrem o modal
    const visualizarBtns = document.querySelectorAll('.btn-visualizar');
    
    // Seleciona o container do modal e o corpo do modal
    const modalContainer = document.getElementById('modal-produto');
    const modalBody = modalContainer.querySelector('.modal-body');
    const modalTitle = modalContainer.querySelector('.modal-title');
    
    // Seleciona todos os botões de fechar
     const closeBtn1 = document.querySelectorAll('.close-modal');
     const closeBtn2 = document.querySelectorAll('.btn-fechar');

    // Adiciona um evento de clique para cada botão "Visualizar"
    visualizarBtns.forEach(btn => {
        btn.addEventListener('click', (event) => {
            const contratoIndex = event.target.getAttribute('data-contrato-index');
            const contrato = contratosData[contratoIndex];

            // Injeta o título do modal
            modalTitle.textContent = `Detalhes do Contrato - ${contrato.produto}`;

            // Lógica para injetar todos os dados no corpo do modal
            modalBody.innerHTML = `
            <p><strong>Nome da Empresa:</strong> ${contrato.NOME_EMPRESA}</p>
            <p><strong>Nome do Produto:</strong> ${contrato.produto}</p>
            <p><strong>Característica:</strong> ${contrato.caracteristica}</p>
            <p><strong>Peso Unidade:</strong> ${contrato.peso_unidade}</p>
            <p><strong>Estoque:</strong> ${contrato.estoque}</p>
            <p><strong>Descrição:</strong> ${contrato.produto_descricao}</p>
            <p><strong>Valor da Oferta:</strong> R$ ${parseFloat(contrato.valor).toFixed(2).replace('.', ',')}</p>
            <p><strong>Marca:</strong> ${contrato.marca}</p>
            <p><strong>Unidade Medida:</strong> ${contrato.unidade_medida}</p>
            `;

            // Exibe o modal
            modalContainer.style.display = 'flex';
        });
    });

    // Adiciona evento de clique para fechar o modal
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

    // Fecha o modal se o usuário clicar fora dele
    window.addEventListener('click', (event) => {
        if (event.target == modalContainer) {
            modalContainer.style.display = 'none';
        }
    });
});