<?php
// models_data.php — каталог моделей apiadult.online (взят по аналогии с hotapi.ai)
// prov: провайдер модели; cat: Chat|Image|Image Editing|Face Swap|Video|Speech
function aasite_models(): array {
    return [
    // ── Chat ──
    ['name'=>'Silly 1.0 Lite','cat'=>'Chat','prov'=>'HotAPI-class','badge'=>'Unrestricted',
     'desc'=>'Budget character chat with image understanding.','price'=>'from $0.30 / 1M tokens'],
    ['name'=>'Silly 2.0','cat'=>'Chat','prov'=>'GLM-5.3 base','badge'=>'',
     'desc'=>'Premium companion roleplay chat that stays in character.','price'=>'from $9.00 / 1M tokens'],
    ['name'=>'Qwen 3.8 27B Spicy','cat'=>'Chat','prov'=>'Qwen','badge'=>'Unrestricted',
     'desc'=>'Uncensored chat with reasoning.','price'=>'from $0.80 / 1M tokens'],

    // ── Image ──
    ['name'=>'Z-Image Pro Spicy','cat'=>'Image','prov'=>'Alibaba Cloud','badge'=>'',
     'desc'=>'Pro-tier text-to-image up to 2560px.','price'=>'$0.03 / image'],
    ['name'=>'Z-Image Spicy','cat'=>'Image','prov'=>'Alibaba Cloud','badge'=>'Unrestricted',
     'desc'=>'Uncensored text-to-image.','price'=>'$0.026 / image'],
    ['name'=>'Seedream 5.0 Pro Spicy','cat'=>'Image','prov'=>'ByteDance','badge'=>'Borderline',
     'desc'=>'Top-tier uncensored image generation.','price'=>'$0.12 / image (list $0.18)'],
    ['name'=>'Seedream 5.0 Lite Spicy','cat'=>'Image','prov'=>'ByteDance','badge'=>'Borderline',
     'desc'=>'Fast uncensored image generation.','price'=>'$0.06 / image (list $0.07)'],

    // ── Image Editing ──
    ['name'=>'Qwen Image Edit Spicy','cat'=>'Image Editing','prov'=>'Qwen','badge'=>'Borderline',
     'desc'=>'Prompt-based image editing.','price'=>'$0.08 / image'],
    ['name'=>'Seedream 5.0 Pro Edit','cat'=>'Image Editing','prov'=>'ByteDance','badge'=>'Borderline',
     'desc'=>'Editing mode of Seedream 5.0 Pro.','price'=>'$0.12 / image'],
    ['name'=>'Seedream 5.0 Lite Edit','cat'=>'Image Editing','prov'=>'ByteDance','badge'=>'Borderline',
     'desc'=>'Editing mode of Seedream 5.0 Lite.','price'=>'$0.06 / image'],
    ['name'=>'Z-Image Edit','cat'=>'Image Editing','prov'=>'Alibaba Cloud','badge'=>'',
     'desc'=>'Prompt-based editing on the Z-Image family.','price'=>'$0.03 / image'],

    // ── Face Swap ──
    ['name'=>'Face Swap Spicy','cat'=>'Face Swap','prov'=>'ByteDance','badge'=>'Borderline',
     'desc'=>'One-call face swap.','price'=>'$0.026 / image'],
    ['name'=>'Head Swap','cat'=>'Face Swap','prov'=>'HotAPI-class','badge'=>'Unrestricted',
     'desc'=>'Whole-head replacement from two images.','price'=>'$0.02 / image'],

    // ── Speech ──
    ['name'=>'Siren 1.0 Spicy','cat'=>'Speech','prov'=>'HotAPI-class','badge'=>'Unrestricted',
     'desc'=>'Expressive speech — breath, pauses and tone, billed by the audio minute.','price'=>'$0.04 / min'],

    // ── Video ──
    ['name'=>'Lime 1.0','cat'=>'Video','prov'=>'HotAPI-class','badge'=>'Unrestricted',
     'desc'=>'Image-to-video with included native audio.','price'=>'from $0.045 / sec'],
    ['name'=>'Wan Animate','cat'=>'Video','prov'=>'Alibaba Cloud','badge'=>'Unrestricted',
     'desc'=>'Reference-driven motion and character replacement.','price'=>'from $0.0795 / sec'],
    ['name'=>'Wan 3.0 Spicy','cat'=>'Video','prov'=>'Alibaba Cloud','badge'=>'Unrestricted',
     'desc'=>'Unrestricted Wan 3.0 video across three input modes (text / image / reference).','price'=>'from $0.075 / sec'],
    ['name'=>'Wan 3.0 Prime Spicy','cat'=>'Video','prov'=>'Alibaba Cloud','badge'=>'Unrestricted',
     'desc'=>'Faster unrestricted Wan 3.0 video.','price'=>'from $0.102 / sec'],
    ['name'=>'Wan 3.0 Pro Spicy','cat'=>'Video','prov'=>'Alibaba Cloud','badge'=>'Unrestricted',
     'desc'=>'Unrestricted Wan 3.0 video in 2K and 4K.','price'=>'from $0.27 / sec'],
    ['name'=>'Wan 3.0 Prime Pro Spicy','cat'=>'Video','prov'=>'Alibaba Cloud','badge'=>'Unrestricted',
     'desc'=>'Faster unrestricted Wan 3.0 video up to 4K.','price'=>'from $0.39 / sec'],
    ['name'=>'Wan 2.7 Spicy','cat'=>'Video','prov'=>'Alibaba Cloud','badge'=>'Unrestricted',
     'desc'=>'Unrestricted image-to-video.','price'=>'from $0.26 / sec'],
    ['name'=>'Wan 2.2 Spicy','cat'=>'Video','prov'=>'Alibaba Cloud','badge'=>'Unrestricted',
     'desc'=>'Lighter Wan for high-volume jobs.','price'=>'from $0.08 / sec'],
    ['name'=>'Seedance 2.5 Spicy','cat'=>'Video','prov'=>'ByteDance','badge'=>'Borderline',
     'desc'=>'Flagship video generation — 4–30s with synced audio.','price'=>'from $0.2056 / sec'],
    ['name'=>'Seedance 2.0 Spicy','cat'=>'Video','prov'=>'ByteDance','badge'=>'Borderline',
     'desc'=>'Previous-generation Seedance video, renders 1080p.','price'=>'from $0.14 / sec'],
    ['name'=>'Seedance 2.0 Fast Spicy','cat'=>'Video','prov'=>'ByteDance','badge'=>'Borderline',
     'desc'=>'Previous-generation, tuned for speed.','price'=>'from $0.053 / sec (list $0.112)'],
    ['name'=>'Seedance 2.0 Mini Spicy','cat'=>'Video','prov'=>'ByteDance','badge'=>'Borderline',
     'desc'=>'Lowest cost per second, identical contract to Fast.','price'=>'from $0.03 / sec (list $0.08)'],
    ['name'=>'MiniMax H3 Spicy','cat'=>'Video','prov'=>'MiniMax','badge'=>'Unrestricted',
     'desc'=>'Uncensored video from text or a first frame, 5–15s with generated audio.','price'=>'from $0.02 / sec (list $0.08)'],
    ['name'=>'Berry 1.0 Spicy','cat'=>'Video','prov'=>'Berry','badge'=>'Best value',
     'desc'=>'Unrestricted video across three input modes.','price'=>'from $0.075 / sec (list $0.10)'],
    ['name'=>'Berry 1.0 Turbo Spicy','cat'=>'Video','prov'=>'Berry','badge'=>'Best value',
     'desc'=>'Faster unrestricted video across three modes.','price'=>'from $0.102 / sec (list $0.136)'],
    ['name'=>'Berry 1.0 Pro Spicy','cat'=>'Video','prov'=>'Berry','badge'=>'Best value',
     'desc'=>'Unrestricted 2K and 4K video generation.','price'=>'from $0.27 / sec (list $0.36)'],
    ['name'=>'Berry 1.0 Pro Turbo Spicy','cat'=>'Video','prov'=>'Berry','badge'=>'Best value',
     'desc'=>'Faster unrestricted video up to 4K.','price'=>'from $0.39 / sec (list $0.52)'],
    ];
}

function aasite_cats(): array {
    return ['Chat','Image','Image Editing','Face Swap','Video','Speech'];
}
