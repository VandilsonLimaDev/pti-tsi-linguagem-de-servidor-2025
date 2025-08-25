<?php

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET) ) {
        $peso = htmlspecialchars($_GET['peso'] ?? 0);
        $altura = htmlspecialchars($_GET['altura'] ?? 0);

        function verificarPreenchimento($peso, $altura){
            if($peso > 200) return '<div class="result error-preenchimento">Valor informado para peso possívelmente errado! Favor verificar.</div>';
            if($altura > 2.3) return '<div class="result error-preenchimento">Valor informado para altura possívelmente errado! Favor verificar.</div>';
        }

        function calcularImc($peso = 0, $altura = 0){
            return $peso / ($altura * $altura);
        }

        $imc = calcularImc($peso, $altura);

        function descobrirFaixa($imc){

            $tabelaFaixaClassificacao = [
                [18.5, "Magreza"],
                [24.9, "Saudável"],
                [29.9, "Sobrepeso"],
                [34.9, "Obesidade Grau I"],
                [39.9, "Obesidade Grau II"],
                [40, "Obesidade Grau III"]
            ];

                for ($i=0; $i < count($tabelaFaixaClassificacao); $i++) { 
                    if($imc <= $tabelaFaixaClassificacao[$i][0]){
                        $faixa = $tabelaFaixaClassificacao[$i][0];
                        $classificacao = $tabelaFaixaClassificacao[$i][1];
                        break;
                    }else if($imc >= 40){
                        $faixa = $imc;
                        $classificacao = "Obesidade Grau III";
                    }
                }
            return [$faixa, $classificacao];
        };

        [$faixa, $classificacao] = descobrirFaixa($imc);

        function notificarResultado($imc, $classificacao){

            $svgMagreza = '<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" id="Layer_1" x="0" y="0" style="enable-background:new 0 0 57.6 68.2" version="1.1" viewBox="0 0 57.6 68.2"><style>.st2{fill:#d32f2f}</style><path d="M19.8 68.2c-3.7 0-7.4-1.5-10.3-4.2-.3-.3-.5-.6-.5-1l-.8-13.2c-.6-.9-1.8-3-1.8-5.3v-7.9c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5v7.9c0 2 1.4 3.9 1.4 3.9.2.2.3.5.3.8l.7 13c2.3 2 5 3 7.9 3 2.8 0 5.5-1 7.9-3l.7-13c0-.3.1-.6.3-.8 0 0 1.4-2 1.4-3.9v-7.9c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5v7.9c0 2.4-1.2 4.5-1.7 5.3L30.6 63c0 .4-.2.8-.5 1-2.9 2.7-6.6 4.2-10.3 4.2z" class="st2"/><path d="M36.3 58.6c-.4 0-.8-.2-1.1-.5s-.4-.7-.4-1.1l.7-14.9c0-.2.1-.4.2-.6 1.1-2.1.8-3.8.4-4.8-.6-1.5-1.7-2.4-2.3-2.6-1.6-.6-6.4-2.3-8.9-3-1.5-.4-2.6-1.8-2.6-3.4v-1.5c-.9.5-1.8.7-2.8.7-.9 0-1.7-.2-2.5-.5v1.3c0 1.6-1.1 3-2.6 3.4-2.5.7-7.3 2.4-8.9 3-.6.2-1.7 1.1-2.3 2.6-.4 1-.6 2.7.4 4.8.1.2.2.4.2.6L4.7 57c0 .4-.1.8-.4 1.1s-.6.5-1 .5c-.9 0-1.5-.6-1.6-1.4L1 42.7c-1.4-2.9-1-5.4-.4-6.9.9-2.4 2.7-3.9 4-4.4 1.6-.6 6.5-2.4 9.2-3.1.3-.1.4-.3.4-.6 0-.9-.1-2.5-.2-3.9l-.7-.7c-.9-.8-1.5-1.9-1.8-3.1-.4-.1-.8-.4-1.3-.7-1.3-1-1.4-2.9-1.4-4.8 0-1.2.6-2.2 1.6-2.8-.1-.5-.1-1-.1-1.4C10.2 4.6 14.4 0 19.6 0S29 4.6 29 10.2c0 .5 0 .9-.1 1.4 1 .6 1.6 1.7 1.6 2.8 0 1.9-.2 3.8-1.4 4.8-.4.3-.9.6-1.3.7-.3 1.2-1 2.3-1.8 3.1l-.4.4c-.1.9-.2 3-.2 4.2 0 .3.2.5.4.6 2.7.8 7.5 2.5 9.2 3.1 1.3.5 3.1 1.9 4 4.4.6 1.5 1 4-.4 6.9l-.7 14.5c-.1.9-.7 1.5-1.6 1.5zM19.6 3c-3.5 0-6.4 3.2-6.4 7.2 0 .5.1 1.1.2 1.6l.8 6.9c.1.8.5 1.6 1.1 2.2l2 2c.6.6 1.4.9 2.2.9s1.6-.3 2.2-.9l2-2c.6-.6 1-1.4 1.1-2.3l.8-6.7c.1-.7.2-1.2.2-1.7.2-4-2.7-7.2-6.2-7.2zM19.8 63.7c-.8 0-1.5-.7-1.5-1.5v-.9c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5v.9c0 .8-.7 1.5-1.5 1.5zM46 24.6c-6.4 0-11.7-5.2-11.7-11.7S39.5 1.3 46 1.3 57.6 6.5 57.6 13 52.4 24.6 46 24.6zm0-2.3c5.2 0 9.3-4.2 9.3-9.3S51.1 3.6 46 3.6s-9.3 4.2-9.3 9.3 4.1 9.4 9.3 9.4zm-5.9-3.5c0-3.2 2.6-5.8 5.8-5.8 3.2 0 5.8 2.6 5.8 5.8h-2.3c0-1.9-1.6-3.5-3.5-3.5s-3.5 1.6-3.5 3.5h-2.3zm1.2-7c-1 0-1.8-.8-1.8-1.8s.8-1.8 1.8-1.8 1.8.8 1.8 1.8-.8 1.8-1.8 1.8zm9.3 0c-1 0-1.8-.8-1.8-1.8s.8-1.8 1.8-1.8 1.8.8 1.8 1.8-.8 1.8-1.8 1.8z" class="st2"/></svg>';
            $svgSaudavel = '<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" id="Layer_1" x="0" y="0" style="enable-background:new 0 0 57.3 68.2" version="1.1" viewBox="0 0 57.3 68.2"><style>.st1{fill:#388e3c}</style><path d="M19.8 68.2c-3.7 0-7.4-1.5-10.3-4.2-.3-.3-.5-.6-.5-1l-.8-13.2c-.6-.9-1.8-3-1.8-5.3v-7.9c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5v7.9c0 2 1.4 3.9 1.4 3.9.2.2.3.5.3.8l.7 13c2.3 2 5 3 7.9 3 2.8 0 5.5-1 7.9-3l.7-13c0-.3.1-.6.3-.8 0 0 1.4-2 1.4-3.9v-7.9c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5v7.9c0 2.4-1.2 4.5-1.7 5.3L30.6 63c0 .4-.2.8-.5 1-2.9 2.7-6.6 4.2-10.3 4.2z" class="st1"/><path d="M36.3 58.6c-.4 0-.8-.2-1.1-.5s-.4-.7-.4-1.1l.7-14.9c0-.2.1-.4.2-.6 1.1-2.1.8-3.8.4-4.8-.6-1.5-1.7-2.4-2.3-2.6-1.6-.6-6.4-2.3-8.9-3-1.5-.4-2.6-1.8-2.6-3.4v-1.5c-.9.5-1.8.7-2.8.7-.9 0-1.7-.2-2.5-.5v1.3c0 1.6-1.1 3-2.6 3.4-2.5.7-7.3 2.4-8.9 3-.6.2-1.7 1.1-2.3 2.6-.4 1-.6 2.7.4 4.8.1.2.2.4.2.6L4.7 57c0 .4-.1.8-.4 1.1s-.6.5-1 .5c-.9 0-1.5-.6-1.6-1.4L1 42.7c-1.4-2.9-1-5.4-.4-6.9.9-2.4 2.7-3.9 4-4.4 1.6-.6 6.5-2.4 9.2-3.1.3-.1.4-.3.4-.6 0-.9-.1-2.5-.2-3.9l-.7-.7c-.9-.8-1.5-1.9-1.8-3.1-.4-.1-.8-.4-1.3-.7-1.3-1-1.4-2.9-1.4-4.8 0-1.2.6-2.2 1.6-2.8-.1-.5-.1-1-.1-1.4C10.2 4.6 14.4 0 19.6 0S29 4.6 29 10.2c0 .5 0 .9-.1 1.4 1 .6 1.6 1.7 1.6 2.8 0 1.9-.2 3.8-1.4 4.8-.4.3-.9.6-1.3.7-.3 1.2-1 2.3-1.8 3.1l-.4.4c-.1.9-.2 3-.2 4.2 0 .3.2.5.4.6 2.7.8 7.5 2.5 9.2 3.1 1.3.5 3.1 1.9 4 4.4.6 1.5 1 4-.4 6.9l-.7 14.5c-.1.9-.7 1.5-1.6 1.5zM19.6 3c-3.5 0-6.4 3.2-6.4 7.2 0 .5.1 1.1.2 1.6l.8 6.9c.1.8.5 1.6 1.1 2.2l2 2c.6.6 1.4.9 2.2.9s1.6-.3 2.2-.9l2-2c.6-.6 1-1.4 1.1-2.3l.8-6.7c.1-.7.2-1.2.2-1.7.2-4-2.7-7.2-6.2-7.2zM19.8 63.7c-.8 0-1.5-.7-1.5-1.5v-.9c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5v.9c0 .8-.7 1.5-1.5 1.5zM45.6 1.3C52 1.3 57.3 6.5 57.3 13s-5.2 11.7-11.7 11.7S33.9 19.4 33.9 13 39.2 1.3 45.6 1.3zm0 2.3c-5.2 0-9.3 4.2-9.3 9.3s4.2 9.3 9.3 9.3 9.3-4.2 9.3-9.3-4.1-9.3-9.3-9.3zm0 8.2c2.3 0 4.3.4 5.8 1.2 0 3.2-2.6 5.8-5.8 5.8-3.2 0-5.8-2.6-5.8-5.8 1.5-.8 3.5-1.2 5.8-1.2zm-4.1-4.7c1.4 0 2.6 1 2.9 2.3h-5.7c.2-1.3 1.4-2.3 2.8-2.3zm8.2 0c1.4 0 2.6 1 2.9 2.3h-5.7c.2-1.3 1.4-2.3 2.8-2.3z" class="st1"/></svg>';
            $svgSobrepeso = '<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" id="Layer_1" x="0" y="0" style="enable-background:new 0 0 58.8 68.3" version="1.1" viewBox="0 0 58.8 68.3"><style>.st0{fill:#ffb300}</style><path d="M43.7 58.6c-.8 0-1.5-.6-1.5-1.5l-.5-14.9c-.1-7.1-2.3-7.9-3.2-8.2l-10-3.1c-1.6-.4-2.7-1.8-2.7-3.4v-1.8c-1 .6-2.1 1-3.3 1-1.2 0-2.3-.3-3.3-1 0 .7.1 1.3 0 1.8 0 1.6-1.2 3-2.8 3.4L6.4 34c-.8.3-3.1 1.1-3.2 8.1L3 57.2c0 .8-.7 1.5-1.5 1.5-.9 0-1.5-.7-1.5-1.5l.5-14.9c.1-6.2 1.7-9.7 5.2-10.9l10.1-3.1c.4-.1.6-.3.6-.6 0-1-.1-3-.3-4.7-.8-.8-1.4-1.9-1.7-3-.4-.1-.8-.4-1.3-.7-1.3-1-1.4-2.9-1.4-4.8 0-1.2.6-2.2 1.6-2.8-.1-.5-.1-1-.1-1.4C13.2 4.6 17.4 0 22.6 0S32 4.6 32 10.2c0 .5 0 .9-.1 1.4 1 .6 1.6 1.6 1.6 2.8 0 1.9-.2 3.8-1.4 4.8-.4.3-.9.6-1.3.7-.3 1.1-.9 2.2-1.7 3-.1 1-.3 3.5-.3 4.7 0 .3.2.5.6.6l10.1 3.1c3.5 1.2 5.2 4.7 5.3 10.9l.5 14.8c0 .9-.7 1.6-1.6 1.6zM22.6 3c-3.5 0-6.4 3.2-6.4 7.2 0 .5.1 1.1.2 1.6l.8 6.9c.1.8.5 1.6 1.1 2.2l2 2c.6.6 1.4.9 2.2.9s1.6-.3 2.2-.9l2-2c.6-.6 1-1.4 1.1-2.3l.8-6.7c.1-.7.2-1.2.2-1.7.2-4-2.7-7.2-6.2-7.2z" class="st0"/><path d="M22.4 68.3c-4.4 0-8.5-.9-11.3-2.4-1.9-1-3.2-3-3.3-5.3v-.1l1.3-10.8c-.4-.9-1.3-3-1.3-5.2 0-2.8 2.2-7.1 2.4-7.6.3-.5.8-.8 1.3-.8.2 0 .5.1.7.2.7.4 1 1.3.7 2-.5 1.1-2.1 4.5-2.1 6.2 0 2.1 1.1 4.2 1.2 4.3.1.3.2.6.2.9l-1.3 10.9c.1 1.1.8 2.1 1.7 2.6 2.4 1.3 6 2 10 2h.2c3.9 0 7.5-.7 9.9-2 1-.5 1.6-1.6 1.7-2.7L33 49.6c0-.3 0-.6.2-.9 0 0 1.1-2.2 1.1-4.3 0-1.8-1.5-5.2-2.1-6.2-.4-.7-.1-1.6.6-2 .2-.1.4-.2.7-.2.6 0 1.1.3 1.3.8.2.5 2.4 4.8 2.4 7.6 0 2.2-.9 4.3-1.3 5.2l1.3 10.7v.1c-.1 2.3-1.4 4.3-3.3 5.4-2.8 1.5-6.9 2.4-11.3 2.4h-.2z" class="st0"/><path d="M22.6 63.7c-.8 0-1.5-.7-1.5-1.5v-.9c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5v.9c0 .8-.7 1.5-1.5 1.5zM55.5 4.9c-2.1-2.1-5-3.4-8.1-3.3-3 0-5.9 1-8 2.8-2.2 1.8-3.4 4.3-3.4 6.9 0 2.5 1.1 4.9 3.1 6.7 2 1.8 4.7 2.9 7.5 3 .2 0 .4.2.4.4v1.9c0 .6.5 1.1 1.1 1.1h.1c6.3-.5 11-5.9 10.5-12.2-.1-2.8-1.3-5.4-3.2-7.3zm-7.7 7.3H47c-.8 0-1.5-.7-1.5-1.5V6.1c0-.8.7-1.5 1.5-1.5h.8c.8 0 1.5.7 1.5 1.5v4.6c0 .8-.6 1.5-1.5 1.5zm1.5 3.8c0 1.1-.9 1.9-1.9 1.9s-1.9-.9-1.9-1.9.9-1.9 1.9-1.9 1.9.9 1.9 1.9z" class="st0"/></svg>';
            $svgObesidade = '<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" id="Layer_1" x="0" y="0" style="enable-background:new 0 0 66.9 73.4" version="1.1" viewBox="0 0 66.9 73.4"><style>.st2{fill:#d32f2f}</style><path d="M28.5 73.4C17.8 73.4 11 71 8.2 66.2c-2.8-4.7-.7-10.2.6-12.8-.2-.5-.4-1-.5-1.4-.2-1.7.6-3.1 1.3-4-1-1.8-1.6-5.1 2.3-9.5 0-.1 0-.3-.1-.4-.1-.4-.1-.8.1-1.1.2-.4.5-.6.9-.7.1 0 .3-.1.5-.1.7 0 1.2.4 1.4 1 .1.3.6 2-.5 3.2-2.4 2.7-3 4.9-1.7 6.6 0 .1.1.1.1.2l.1.1s.9 1.2 3.6 1.3c.4 0 1-.2 1.6-.4 1-.3 2.3-.7 3.9-.7h.7c.4 0 .8.2 1 .5.3.3.4.7.4 1.1-.1.8-.7 1.4-1.5 1.4h-.5c-1.2 0-2.1.3-3 .6-.8.3-1.6.5-2.4.5h-.2c-2.2-.1-3.7-.8-4.6-1.4-.2.4-.4.8-.4 1.3.1.9 1.3 1.9 3.3 2.8.4.2.7.5.8.8.1.4.1.8 0 1.1-.2.5-.8.9-1.4.9-.2 0-.4 0-.6-.1-.9-.4-1.8-.9-2.4-1.3-1 2.4-1.9 6-.2 8.9 2.2 3.8 8.2 5.7 17.7 5.7s15.4-1.9 17.7-5.7c1.7-2.9.8-6.5-.2-8.9-.7.5-1.5.9-2.4 1.3-.2.1-.4.1-.6.1-.6 0-1.1-.4-1.4-.9-.2-.4-.2-.8 0-1.1.1-.4.4-.7.8-.8 2-.9 3.2-1.9 3.3-2.8.1-.5-.1-.9-.4-1.3-.9.6-2.4 1.3-4.6 1.4h-.2c-.8 0-1.6-.2-2.3-.5h-.1c-.9-.3-1.8-.6-3-.6h-.5c-.8 0-1.4-.6-1.5-1.4 0-.4.1-.8.4-1.1.3-.3.6-.5 1-.5h.7c1.6 0 2.9.4 3.9.7.6.2 1.2.4 1.6.4 2.7-.1 3.6-1.3 3.6-1.4l.1-.1c0-.1.1-.1.1-.2 1.3-1.7.8-3.9-1.7-6.6-1.1-1.2-.6-2.9-.5-3.2.2-.6.8-1 1.4-1 .2 0 .3 0 .5.1.4.1.7.4.9.7.2.4.2.8.1 1.1 0 .1-.1.3-.1.4 3.9 4.4 3.3 7.6 2.3 9.5.7.9 1.5 2.3 1.3 4-.1.5-.2 1-.5 1.4 1.3 2.6 3.4 8.1.6 12.8-2.9 4.9-9.7 7.3-20.3 7.3z" class="st2"/><path d="M47.6 51.8c.2-1.7-1-3.1-1.6-3.7 1.3-1.8 2-4.7-1.9-9-.2-.3-.1-1 0-1.2.1-.3-.1-.5-.3-.6-.3-.1-.5.1-.6.3 0 .1-.4 1.5.3 2.2 2.8 3.1 3.4 5.8 1.7 7.9 0 .1-.1.1-.1.2l-.1.1c0 .1-1.2 1.6-4.4 1.8-.6 0-1.2-.2-1.9-.4-1.1-.3-2.4-.8-4.2-.7-.3 0-.5.3-.5.5 0 .3.2.5.5.5 1.6-.1 2.8.3 3.8.6.8.2 1.5.5 2.3.4 2.7-.1 4.2-1.2 4.8-1.8.5.5 1.4 1.6 1.2 2.8-.2 1.3-1.5 2.5-3.9 3.6-.3.1-.4.4-.3.7.1.2.3.3.5.3h.2c1.4-.6 2.5-1.3 3.2-2 1.2 2.4 3 7.1.7 11-2.4 4.1-8.7 6.2-18.5 6.2S12.4 69.4 10 65.3c-2.3-3.9-.5-8.6.7-11 .8.7 1.8 1.4 3.2 2h.2c.2 0 .4-.1.5-.3.1-.3 0-.5-.3-.7-2.4-1-3.7-2.3-3.9-3.6-.2-1.2.7-2.3 1.2-2.8.6.6 2.1 1.7 4.8 1.8.8 0 1.5-.2 2.3-.4 1.1-.3 2.3-.7 3.8-.6.3 0 .5-.2.5-.5s-.2-.5-.5-.5c-1.8-.1-3.1.3-4.2.7-.7.2-1.4.4-1.9.4-3.2-.1-4.4-1.7-4.4-1.8l-.1-.1c0-.1 0-.1-.1-.2-1.6-2.1-1-4.8 1.7-7.9.7-.8.3-2.1.3-2.2-.1-.3-.4-.4-.6-.3-.3.1-.4.4-.3.6.1.3.2 1 0 1.2-3.9 4.3-3.2 7.3-1.9 9-.6.6-1.8 2-1.6 3.7.1.5.3 1 .6 1.5-1.3 2.4-3.5 7.8-.9 12.3 2.6 4.4 9.1 6.7 19.4 6.7 10.3 0 16.8-2.2 19.4-6.7 2.7-4.5.4-10-.9-12.3.4-.4.6-.9.6-1.5z" class="st2"/><path d="M55.4 62.9c-.9 0-1.5-.7-1.5-1.6 0-.8-.8-5.6-1.5-9.4-.9-4.7-1.8-10.1-2.2-13.3-.6-5.1-5.6-5.9-5.8-6-.2 0-.4-.1-.5-.2-.3-.2-1.7-.9-7.1-3.1-1.8-.7-2.9-2.4-2.9-4.3-.4.2-.8.3-1.1.3-1.2.9-2.7 1.4-4.3 1.4-1.5 0-3.1-.5-4.3-1.4-.3-.1-.7-.1-1.1-.3 0 1.9-1.1 3.6-2.9 4.3-5.5 2.2-6.8 2.9-7.1 3.1-.2.1-.3.2-.5.2s-5.2.9-5.8 6c-.4 3.3-1.4 8.6-2.3 13.4-.7 3.8-1.5 8.6-1.5 9.4 0 .8-.6 1.5-1.4 1.6-.9 0-1.5-.6-1.6-1.4 0-1 .4-3.9 1.6-10.1.8-4.7 1.8-10 2.2-13.1.7-6.5 6.8-8.3 8-8.5 1-.6 3.5-1.6 7.3-3.2.7-.3 1.1-.9 1-1.6-.2-1.9-.6-4.1-.7-4.5v-.4c-.4-.1-.9-.3-1.3-.6-1.4-1-1.6-3-1.6-4.8 0-1.2.6-2.2 1.8-2.9-.1-.5-.1-.9-.1-1.4C18.1 4.6 22.8 0 28.5 0s10.4 4.6 10.4 10.2c0 .5 0 .9-.1 1.4 1.1.6 1.8 1.7 1.8 2.9 0 1.8-.2 3.8-1.6 4.8-.4.3-.9.5-1.3.6v.5c-.1.5-.4 2.7-.7 4.6-.1.7.3 1.4 1 1.6 3.8 1.5 6.3 2.6 7.3 3.2 1.3.3 7.3 2 8 8.5.3 3.1 1.3 8.4 2.2 13.1 1.1 6.2 1.6 9.1 1.6 10.1-.2.8-.8 1.4-1.7 1.4zM28.5 3c-4.1 0-7.4 3.2-7.4 7.2 0 .5.1 1 .2 1.6l.9 7v.1c.1 3.5 2.4 3.7 2.6 3.7.4 0 .7.1.9.4.7.6 1.7 1 2.7 1s1.9-.4 2.7-1c.3-.2.6-.4.9-.4.3 0 2.5-.2 2.6-3.6v-.2l.9-6.7c.1-.7.2-1.2.2-1.7.2-4.2-3.1-7.4-7.2-7.4zM28 68.9c-.8 0-1.5-.7-1.5-1.5s.7-1.5 1.5-1.5h.9c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H28z" class="st2"/><path d="M55.3 27.2c-6.4 0-11.7-5.2-11.7-11.7S48.8 3.9 55.3 3.9 67 9.1 67 15.6s-5.3 11.6-11.7 11.6zm0-2.3c5.2 0 9.3-4.2 9.3-9.3s-4.2-9.3-9.3-9.3-9.3 4.2-9.3 9.3 4.1 9.3 9.3 9.3zm-5.9-3.5c0-3.2 2.6-5.8 5.8-5.8 3.2 0 5.8 2.6 5.8 5.8h-2.3c0-1.9-1.6-3.5-3.5-3.5s-3.5 1.6-3.5 3.5h-2.3zm1.2-7c-1 0-1.8-.8-1.8-1.8s.8-1.8 1.8-1.8 1.8.8 1.8 1.8-.8 1.8-1.8 1.8zm9.3 0c-1 0-1.8-.8-1.8-1.8s.8-1.8 1.8-1.8 1.8.8 1.8 1.8-.8 1.8-1.8 1.8z" class="st2"/></svg>';

            if($classificacao === "Magreza"){
                $classeResult = "error-danger";
                $classSVG = $svgMagreza;
            }else if( $classificacao === "Saudável"){
                $classeResult = "error-success";
                $classSVG = $svgSaudavel;
            }else if( $classificacao === "Sobrepeso"){
                $classeResult = "error-warning";
                $classSVG = $svgSobrepeso;
            }else{
                $classeResult = "error-danger";
                $classSVG = $svgObesidade;
            }

            echo '<div class="result '.$classeResult.'">';
            echo    '<div class="icon-svg">' . $classSVG . '</div>';
            echo    '<div>';
            echo        'Atenção, seu IMC é <span class="title-result">' . number_format($imc,2,',') . '</span> e você está classificado como <span class="title-result">' . $classificacao .'</span>';
            echo    '</div>';
            echo '</div>';
        }

    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produção Textual Individual - PTI</title>
    <link type="image/x-icon" rel="shortcut icon" href="https://www.ead.senac.br/portal/public/assets/img/favicon/favicon-32x32.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-default: #212121;
            --color-primary: #004587;
            --color-secondary: #f9a94a;
            --color-default-2: #808080;
            --color-danger: #D32F2F;
            --color-danger-bg: #ffd9d9ff;
            --color-warning: #FFB300;
            --color-warning-bg: #ffecbfff;
            --color-success: #388E3C;
            --color-success-bg: #d7ffd9ff;
            --color-input: #fcf4edff;
            --color-input-focus: #fdf3e7 ;
            --border-radius: 0.4rem;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: "Open Sans", sans-serif;
            background-color: #efefef;
            display:flex;
            height:100dvh;
            justify-content:center;
            flex-direction: column;
        }
        header {
            align-items: center;
            display:flex;
            justify-content:center;
            gap:2rem;
            padding-block: 0.5rem 1rem;
        }
        form {
            margin-block:1rem;
            display:flex;
            flex-wrap:wrap;
            flex-direction: column;
            justify-content: space-between;
            gap:.2rem;
        }
        form .input {
            border-radius:var(--border-radius);
            background-color:var(--color-input);
            border:none;
            padding:1rem 1rem;
            flex:1;
        }
        form .input:focus {
            outline:none;
            background-color: var(--color-input-focus);
        }
        form .input::placeholder {
            color: var(--color-secondary);
        }
        footer {
            border-top: 1px solid var(--color-input);
            color:var(--color-default-2);
            font-size:0.8rem;
            margin-top:1.5rem;
            padding-top:1rem;
            text-align:center;
        }
        em {color: var(--color-secondary)}
        .btn {
            background: var(--color-secondary);
            border:none;
            border-radius:var(--border-radius);
            color:white;
            cursor:pointer;
            display:block;
            font-weight:bold;
            height: 2.8rem;
        }
        .btn-reset {
            display:flex;
            align-items: center;
            justify-content: center;
            text-decoration:none;
            
        }
        .title {
            color: var(--color-primary);
            letter-spacing: -1px;
            font-size:2.2rem;
            text-align:center;
            padding-block: 1.2rem 0rem ;
        }
        .title-result {
            display:block;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .subtitle {
            text-align:center;
        }
        .subtitle2 {
            text-align:center;
            padding-bottom:2rem;
        }
        .linha {
            border-top: 4px solid var(--color-secondary);
            border-bottom: 4px solid var(--color-primary);
            width: 100%;
            height:8px;
        }
        .container {
            background-color:white;
            box-sizing: border-box;
            border-radius:var(--border-radius);
            box-shadow: 5px 5px 10px rgba(0,0,0,.1);
            max-width: 100%;
            margin:0 auto;
            padding-block: 1.5rem 2rem;
            padding-inline: 2.5rem; 
            width: 600px;
        }
        .container-btns {
            /* display:flex;
            flex:1; */
            /* gap:0.2rem; */
        }
        .container-btns * {
            flex:1;
        }
        .result {
            border-radius: var(--border-radius);
            display: flex;
            gap:2rem;
            align-items: center;
            padding: 1.5rem 2.5rem 2rem 2.5rem;
            background-color: var(--color-error-bg);
        }
        .error-danger {background-color: var(--color-danger-bg);}
        .error-danger .title-result {color: var(--color-danger);}
        .error-warning {background-color: var(--color-warning-bg);}
        .error-warning .title-result {color: var(--color-warning);}
        .error-success {background-color: var(--color-success-bg);}
        .error-success .title-result {color: var(--color-success);}
        
        .icon-svg {
            width: 100px;
        }

        @media screen and (min-width: 600px) {
            form {
                display:flex;
                flex-direction: row;
                align-items:center;
            }
            .btn {
                padding-inline:0.2rem;
            }
            .btn-reset {
                padding-inline:0.2rem;
                
            }
        }
    </style>

</head>
<body>

    <div class="container">
        <header>
            <img src="https://www.ead.senac.br/public/assets/img/logo.png" alt="" />
            <div>
                <h3>Linguagens de Servidor</h3>
                <p>Prof. Carlos Henrique Veríssimo Pereira</p>
                <p>Tutora Profa. Daniela Rosa Ferreira</p>
            </div>
        </header>
        <div class="linha"></div>
       <h1 class="title"><?= "Calculadora de IMC" ?></h1>
       <h3 class="subtitle2">Produção Textual Individual - PTI</h3>
       <p class="subtitle">Informe seu peso<em>(quilogramas)</em> e altura<em>(metro)</em> para o cálculo</p>

        <form action="" method="GET">
            <input class="input" type="text" name="peso" placeholder="Peso em kg (Ex.: 65.7)" tabindex="1" required <?= !empty($_GET["peso"]) ? 'value="'. $_GET["peso"] .'"' : "";?>>
            <input class="input" type="text" name="altura" placeholder="Altura em metro (Ex.: 1.75)" tabindex="2" <?= !empty($_GET["altura"]) ? 'value="'. $_GET["altura"] .'"' : "";?> required>
            
                <input class="btn" type="submit" value="OK" tabindex="3">
                <?= !empty($_GET["peso"]) ? '<a class="btn btn-reset" href="./" tabindex="4">Reset</a>' : "";?>
            
            
        </form>

        <?php 
            if(function_exists('notificarResultado')){
                notificarResultado($imc, $classificacao);
            }
        ?>

        <footer>
            <p>Curso:<strong> Sistemas para Internet</strong> | Aluno: <strong>Vandilson Fábio de Lima</strong> &copy; <?= date("Y")?></p>
        </footer>
    </div>

</body>
</html>

<!--
/**
 *      Olá, professor/tutora.
 *      Além do código-fonte, hospedei a aplicação Calculadora de IMC
 *      no seguinte endereço, para facilitar a visualização e teste:
 *      URL: https://pti-tsi-linguagem-de-servidor-2025.vercel.app/
 *      Qualquer problema de acesso ou dúvida, por favor, me avise.
 *      Agradeço a atenção.
 */
-->