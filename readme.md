# Integração RD Station - WordPress

## Integre seus formulários de contato do WordPress com o RD Station

Com este plugin você pode integrar qualquer formulário do seu site ou blog e ter controle sobre esses formulários integrados.

Endereço oficial: [https://wordpress.org/plugins/integracao-rd-station/](https://wordpress.org/plugins/integracao-rd-station/)

### Compatibilidade

O plugin **Integração RD Station** atualmente é compatível com os seguintes plugins de formulário:

* [Contact Form 7](#contact-form-7)
* [Gravity Forms](#gravity-forms)
* [MailChimp For WordPress](#mailchimp-for-wp)

### Instalação

Se o seu site ou blog foi desenvolvido pela Resultados Digitais, este plugin já está instalado e você pode pular para a parte de [configuração](#configuração). Caso contrário, siga estes passos:  

Você pode instalar o plugin diretamente pelo seu painel do WordPress, clicando em **Plugins**, **Adicionar novo** e pesquise por **Integração RD Station**. Provavelmente será o único plugin a aparecer nos resultados da pesquisa. Basta clicar em **Instalar** e depois em **Ativar**. Seu plugin está funcionando e você já pode pular para a parte de configuração.

Caso você prefira instalar o plugin manualmente, você pode baixá-lo [clicando neste link](https://github.com/ResultadosDigitais/rdstation-wp/archive/master.zip) ou baixando o arquivo ZIP diretamente pelo [endereço oficial](https://wordpress.org/plugins/integracao-rd-station/).
  
Para instalá-lo no seu site, você precisa entrar no seu painel do WordPress, clicar em **Plugins**, **Adicionar novo** e depois em **Fazer upload do plugin**. Então selecione o arquivo que você baixou e clique em **Instalar agora**. Se o plugin foi instalado com sucesso, clique em **Ativar plugin**.

### Configuração

Depois de instalar o plugin, irá aparecer um item no seu menu WordPress, de acordo com o plugin de formulários que você tem instalado e ativo. Se você tem o Contact Form 7, irá aparecer **RD Station CF7**, já se você tiver o Gravity Forms, irá aparecer **RD Station GF**.
Se você tiver os dois formulários instalados, ambos estarão ativos no seu menu, e você pode usar os dois formulários simultaneamente sem problemas.

#### Contact Form 7

A integração no Contact Form 7 só irá funcionar com formulários que possuem um campo chamado **email** ou **your-email**. Sem esse campo, a API do RD Station não realiza a conversão dos leads.

Para fazer uma integração, clique no item **RD Station CF7** que apareceu no menu do seu painel. Para criar uma nova integração, basta clicar em **Criar integração** e preencher os dados solicitados no formulário.

Crie um título para sua integração, apenas para organizar suas integrações e encontrá-la posteriormente no seu painel.

No campo **Identificador**, crie um Identificador para seu formulário. Isso é importante para você saber qual o formulário de origem do *lead*.  
Preencha o campo **Token RD Station** com o seu **Token Público** do RD Station. Este token, você pode encontrar em: http://rdstation.com.br/integracoes  
Por último, selecione qual formulário você deseja integrar. Este campo traz uma lista com todos os formulários criados no Contact Form 7.  

Clique em **Integrar**. Pronto, seu formulário escolhido está integrado ao RD Station.


#### Gravity Forms

Para a integração com o Gravity Forms funcionar, você precisa ter pelo menos um campo do tipo **e-mail** no seu formulário.  
Veja como criar campos do tipo e-mail no Gravity Forms na [Central de Ajuda do RD Station](http://ajuda.rdstation.com.br/hc/pt-br/articles/205542309)

Para fazer uma integração, clique no item **RD Station GF** que apareceu no menu do seu painel. Após isso o processo para criar uma nova integração é o mesmo do Contact Form 7: clique em **Criar integração** e preencha os dados solicitados no formulário.

Siga os mesmos passos usados no [Contact Form 7](#contact-form-7)

Clique em **Integrar** e seu formulário escolhido está integrado ao RD Station.

### Múltiplas integrações
Você pode integrar quantos formulários for necessário. Além disso, você também pode integrar um único formulário a mais de uma conta no RD Station, criando duas integrações com tokens diferentes. Isso pode ser útil quando você criar alguma campanha com um parceiro, e precisa gerar o lead para as duas contas.

### Campos personalizados

Para que os dados de um campo do formulário sejam enviados como campo personalizado para o seu RD Station, você só precisa criar um campo no formulário com o mesmo nome definido no RD Station. Por exemplo, se você tem um campo personalizado chamado **idioma**, você só precisa criar um campo no seu formulário com `name="idioma"`.

#### MailChimp For WordPress

Para fazer uma integração, clique no item **RD Station MC4WP** que apareceu no menu do seu painel. 

No campo **Identificador**, crie um Identificador. Isso é importante para você saber qual a origem do *lead*.  
Preencha o campo **Token RD Station** com o seu **Token Público** do RD Station. Este token, você pode encontrar em: http://rdstation.com.br/integracoes 

Clique em **Integrar**. Pronto, todos os formulários do MailChimp For WordPress estão integrados.