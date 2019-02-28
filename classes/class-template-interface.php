<?php

namespace GingerSoul\SoulCodes;

interface Template_Interface {
    /**
     * Renders this template with the given context.
     *
     * @param array $context The data to render the template with.
     *
     * @return string The rendered template.
     */
    public function render($context);
}
