<?php 
namespace hedronium\SpacelessBlade;
use Blade;

class SpacelessBladeProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        //Register the Starting Tag
        Blade::directive('spaceless', function() {
            return '<?php ob_start() ?>';
        });

        //Register the Ending Tag
        Blade::directive('endspaceless', function() {

            $output = <<< ENDLINEASD
<?php
\$filtersspaceless = [
    '/<!--([^\[|(<!)].*)/'      => '',
    '/(?<!\S)\/\/\s*[^\\r\\n]*/'	=> '',
    '/\s{2,}/'			        => ' ',
    '/(\\r?\\n)/'			        => '',
    '/(\>)\s*(\<)/m'            => '$1$2',
];
echo preg_replace(array_keys(\$filtersspaceless), array_values(\$filtersspaceless), ob_get_clean());
?>
ENDLINEASD;
            return $output;
        });
    }

    public function register(){}
}
