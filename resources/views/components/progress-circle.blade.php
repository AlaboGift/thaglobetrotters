<style type="text/css">
    @for($i = 5; $i < 360; $i+=5)

        @keyframes loading-{{ceil($i)}}{
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg)
            }

            100% {
                -webkit-transform: rotate({{ceil($i)}}deg);
                transform: rotate({{ceil($i)}}deg)
            }
        }
    @endfor
</style>