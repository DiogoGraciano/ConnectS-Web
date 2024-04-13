<?php
namespace app\classes;

/**
 * Classe de funções utilitárias
 */
class functions{
    
    /**
     * Retorna o diretório raiz do servidor
     *
     * @return string O diretório raiz do servidor
     */
    public static function getRaiz(){
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Obtém a URI atual da requisição.
     *
     * @return string   Retorna a URI atual da requisição.
     */
    public static function getUri(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
    
    /**
     * Retorna a URL base do site
     *
     * @return string A URL base do site
     */
    public static function getUrlBase()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . "/";
    }
    
    /**
     * Decodifica uma string UTF-8 codificada para URL
     *
     * @param string $str A string codificada para URL
     * @return string A string decodificada
     */
    public static function utf8_urldecode(string $str) {
        return mb_convert_encoding(preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", urldecode($str)),'UTF-8');
    }
    
    /**
     * Remove todos os caracteres não numéricos de uma string
     *
     * @param string $value A string a ser filtrada
     * @return string A string contendo apenas números
     */
    public static function onlynumber(string $value){
        $value = preg_replace("/[^0-9]/","", $value);
        return $value;
    }

    /**
     * Converte uma string para o formato de data e hora do banco de dados
     *
     * @param string $string A string contendo a data e hora
     * @return string|bool A string formatada ou false se falhar
     */
    public static function dateTimeBd(string $string){
        $datetime = new \DateTimeImmutable($string);
        if ($datetime !== false)
            return $datetime->format('Y-m-d H:i:s');

        return false;
    }

    /**
     * Converte uma string para o formato de data do banco de dados
     *
     * @param string $string A string contendo a data
     * @return string|bool A string formatada ou false se falhar
     */
    public static function dateBd(string $string){
        $datetime = new \DateTimeImmutable($string);
        if ($datetime !== false)
            return $datetime->format('Y-m-d');

        return false;
    }

    /**
     * Formata um CNPJ ou CPF
     *
     * @param string $value O valor do CNPJ ou CPF
     * @return string O valor formatado
     */
    public static function formatCnpjCpf(string $value)
    {
        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return functions::mask($cnpj_cpf, '###.###.###-##');
        } 
        
        return functions::mask($cnpj_cpf, '##.###.###/####-##');
    }

    /**
     * Aplica uma máscara a uma string
     *
     * @param string $val A string original
     * @param string $mask A máscara a ser aplicada
     * @return string A string com a máscara aplicada
     */
    public static function mask(string $val,string $mask) {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k])) $maskared .= $val[$k++];
            } else {
                if(isset($mask[$i])) $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    /**
     * Formata uma string de tempo para o formato HH:MM:SS ou HH:MM
     *
     * @param string $time A string de tempo a ser formatada
     * @return string A string de tempo formatada
     */
    public static function formatTime($time){
        if ($tamanho = substr_count($time,":")){
            if ($tamanho == 2){
                return $time;
            }
            if ($tamanho == 1){
                return $time.":00";
            }
        }
        else{
            return $time.":00:00";
        }
    }

    /**
     * Remove os segundos de uma string de tempo
     *
     * @param string $time A string de tempo a ser modificada
     * @return string A string de tempo sem os segundos
     */
    public static function removeSecondsTime($time){
        if ($tamanho = substr_count($time,":")){
            if ($tamanho == 2){
                $time = explode(":",$time);
                return $time[0].":".$time[1];
            }
            if ($tamanho == 1){
                return $time;
            }
        }
        else{
            return $time.":00";
        }
    }

    /**
     * Formata uma string contendo dias, substituindo vírgulas por espaços
     *
     * @param string $dias A string contendo os dias
     * @return string A string formatada
     */
    public static function formatDias($dias){
        $dias = str_replace(","," ",$dias);
        $dias = trim($dias);

        return $dias;
    }

    /**
     * Formata um número de telefone para o formato (XX) XXXX-XXXX
     *
     * @param string $phone O número de telefone a ser formatado
     * @return string O número de telefone formatado
     */
    public static function formatPhone($phone)
    {
        $formatedPhone = preg_replace('/[^0-9]/', '', $phone);
        $matches = [];
        preg_match('/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/', $formatedPhone, $matches);
        if ($matches) {
            return '('.$matches[1].') '.$matches[2].'-'.$matches[3];
        }

        return $phone; 
    }

    /**
     * Criptografa uma string usando AES-256-CBC
     *
     * @param string $data A string a ser criptografada
     * @return string A string criptografada
     */
    public static function encrypt($data)
    {
        $first_key = base64_decode(FIRSTKEY);
        $second_key = base64_decode(SECONDKEY);    
            
        $method = "aes-256-cbc";    
        $iv_length = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_length);
                
        $first_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);    
        $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
                    
        $output = base64_encode($iv.$second_encrypted.$first_encrypted);  
        
        $output = str_replace("/","@",$output);

        return $output;        
    }

    /**
     * Descriptografa uma string criptografada usando AES-256-CBC
     *
     * @param string $input A string criptografada
     * @return string|bool A string descriptografada ou false se falhar
     */
    public static function decrypt($input)
    {
        $input = str_replace("@","/",$input);
        
        $first_key = base64_decode(FIRSTKEY);
        $second_key = base64_decode(SECONDKEY);            
        $mix =  base64_decode($input);
                
        $method = "aes-256-cbc";    
        $iv_length = openssl_cipher_iv_length($method);
                    
        $iv = substr($mix,0,$iv_length);
        $second_encrypted = substr($mix,$iv_length,64);
        $first_encrypted = substr($mix,$iv_length+64);
                    
        $data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
        $second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
            
        if (hash_equals($second_encrypted,$second_encrypted_new))
            return $data;
            
        return false;
    }

    /**
     * Formata um valor monetário para o formato de moeda brasileira
     *
     * @param string $input O valor monetário
     * @return string O valor monetário formatado
     */
    public static function formatCurrency($input)
    {
        $input = preg_replace("/[^0-9.,]/", "", $input);

        $fmt = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY );
        return $fmt->format($input);
    }

    /**
     * Remove a formatação de moeda e retorna um valor numérico
     *
     * @param string $input O valor monetário formatado
     * @return float O valor numérico
     */
    public static function removeCurrency($input)
    {
        return floatval(str_replace(",",".",preg_replace("/[^0-9.,]/", "", $input)));
    }

    /**
     * Gera um código aleatório baseado em bytes randômicos
     *
     * @param int $number O número de bytes para gerar o código
     * @return string O código gerado
     */
    public static function genereteCode($number){
        return strtoupper(substr(bin2hex(random_bytes($number)), 1));
    }

    /**
     * Formata um endereço IP para o formato XXX.XXX.XXX.XXX
     *
     * @param string $ip O endereço IP a ser formatado
     * @return string|bool O endereço IP formatado ou false se inválido
     */
    public static function formatarIP($ip) {

        $ip = preg_replace('/\D/', '', $ip);

        $tamanho = strlen($ip);

        // Validar se o IP possui 12 dígitos
        if ($tamanho < 4 || $tamanho > 12) {
            // Se não tiver 12 dígitos, retorne false
            return false;
        }

        // Formatar o IP no formato desejado (XXX.XXX.XXX.XXX)
        return sprintf("%03d.%03d.%03d.%03d", substr($ip, 0, 3), substr($ip, 3, 3), substr($ip, 6, 3), substr($ip, 9, 3));

    }

     /**
     * Formata um número de telefone para o formato (XX) XXXX-XXXX ou (XX) XXXXX-XXXX
     *
     * @param string $telefone O número de telefone a ser formatado
     * @return string|bool O número de telefone formatado ou false se inválido
     */
    public static function formatarTelefone($telefone) {
        // Remover quaisquer caracteres que não sejam dígitos
        $telefone = preg_replace('/\D/', '', $telefone);
        
        // Verificar se o número de telefone tem o comprimento correto
        if (strlen($telefone) != 10 && strlen($telefone) != 11) {
            return false; // Retornar falso se o comprimento for inválido
        }
        
        // Se o número tiver 11 dígitos, remover o primeiro dígito (código de área)
        if (strlen($telefone) == 11) {
            $telefone = substr($telefone, 1);
        }
        
        // Formatar o número de telefone no estilo desejado (XX) XXXX-XXXX
        return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 4) . '-' . substr($telefone, 6);
    }
}

?>