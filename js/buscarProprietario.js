        // Função para buscar os proprietários no banco de dados com AJAX
        function buscarProprietarios() {
            const input = document.getElementById('prop');
            const sugestoes = document.getElementById('sugestoes');
            const query = input.value;

            // Limpar a lista de sugestões se o campo estiver vazio
            if (query.length === 0) {
                sugestoes.innerHTML = '';
                return;
            }

            // Fazer a requisição AJAX para buscar os proprietários
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '../config/buscar_proprietarios.php?query=' + encodeURIComponent(query), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const proprietarios = JSON.parse(xhr.responseText);
                    sugestoes.innerHTML = '';

                    // Adicionar as sugestões à lista
                    proprietarios.forEach(proprietario => {
                        const li = document.createElement('li');
                        li.textContent = proprietario.nome_pessoa;
                        li.onclick = function() {
                            input.value = proprietario.nome_pessoa; // Preencher o input com o nome selecionado
                            sugestoes.innerHTML = ''; // Limpar as sugestões
                        };
                        sugestoes.appendChild(li);
                    });
                }
            };
            xhr.send();
        }