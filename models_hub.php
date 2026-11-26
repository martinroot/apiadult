<?php
// models_hub.php — детальные страницы моделей (по референсу hotapi.ai)
// media: локальные пути из /media/<dir>/NN.jpg|mp4
function models_hub(): array {
    return [
'w3.0-spicy' => [
  'name' => 'Wan 3.0 Spicy',
  'slug' => 'w3.0-spicy',
  'cat'  => 'Video',
  'prov' => 'Alibaba Cloud',
  'badge'=> 'Unrestricted',
  'tagline' => 'Unrestricted text, keyframe and reference video in one family.',
  'desc' => 'Three separate input contracts — text, keyframe, reference — at one per-second rate. Holds a single unbroken shot up to 30 seconds with a synchronised audio track.',
  'hero' => ['type'=>'video','src'=>'/media/w30/10.mp4'],
  'stats' => [
    ['5','kinds','Images, videos, audio, a document, or a web page as input.'],
    ['30s','length','Any whole-second duration from 2 to 30, one continuous take.'],
    ['audio','built-in','Generate a synchronised track or switch to silent, per request.'],
    ['6','ratios','Adaptive plus 16:9, 4:3, 1:1, 3:4, 9:16.'],
    ['3','modes','Text, keyframe and reference bill the same per-second rate.'],
    ['$0.075/s','entry rate','At 480p, with a $0.15 minimum per task.'],
  ],
  'features' => [
    ['title'=>'Thirty seconds, one take','desc'=>'Text-to-video holds a single unbroken shot up to 30 seconds — no cuts, no coverage, one continuous performance with a generated audio track.','media'=>['type'=>'video','src'=>'/media/w30/11.mp4']],
    ['title'=>'Direct the motion, not just the look','desc'=>'Up to five reference videos reproduce your camera position and pacing on a different subject and scene. References cap at 1–15s each, 15s total.','media'=>['type'=>'video','src'=>'/media/w30/12.mp4']],
    ['title'=>'Your written brief, performed','desc'=>'Attach a document reference — a markdown scene brief with beats, wardrobe, camera, lighting — and the model shoots it. Document and page references require prompt expansion, enabled for you.','media'=>['type'=>'video','src'=>'/media/w30/13.mp4']],
  ],
  'usecases' => [
    ['Explicit scene generation','Direct sex acts, fetish detail and solo material from a written brief — the content line is the product, not an edge case.'],
    ['Frame-locked motion','Animate a required first frame with an optional last frame — opening and final composition are both contracts.'],
    ['Performance transfer','Reproduce a specific camera move, pace or gesture from a reference video onto a different subject.'],
    ['Script-to-scene pipelines','Attach a document or a page — written scenarios, shot lists and listing pages become clips.'],
  ],
  'howto' => 'Pick a mode, attach what you have, collect the task:',
  'code' => 'curl https://apiadult.online/v1/videos \\
  -H "Authorization: Bearer $APIADULT_KEY" \\
  -H "Content-Type: application/json" \\
  -d \'{
    "model": "wan-3-0-spicy",
    "mode": "text",
    "prompt": "[Static shot] A hotel suite in the late afternoon...",
    "duration": 30,
    "ratio": "16:9",
    "resolution": "480p",
    "audio": true
  }\'',
  'price' => 'from $0.075 / sec · min $0.15 / task',
  'gallery' => [['type'=>'image','src'=>'/media/w30/01.jpg'],['type'=>'image','src'=>'/media/w30/02.jpg'],['type'=>'image','src'=>'/media/w30/03.jpg'],['type'=>'image','src'=>'/media/w30/04.jpg'],['type'=>'image','src'=>'/media/w30/05.jpg'],['type'=>'image','src'=>'/media/w30/06.jpg'],['type'=>'image','src'=>'/media/w30/07.jpg'],['type'=>'image','src'=>'/media/w30/08.jpg'],['type'=>'image','src'=>'/media/w30/09.jpg']],
],
'z-image-spicy-pro' => [
  'name' => 'Z-Image Spicy Pro',
  'slug' => 'z-image-spicy-pro',
  'cat'  => 'Image',
  'prov' => 'Alibaba Cloud',
  'badge'=> '',
  'tagline' => 'Pro-tier uncensored text-to-image up to 2560px, flat $0.03 per image.',
  'desc' => 'The Pro tier of the Z-Image line: the same uncensored text-to-image contract as Z-Image Spicy, on a canvas up to 2560px per side, with seeded runs that reproduce a render byte-exactly.',
  'hero' => ['type'=>'image','src'=>'/media/zimage/01.jpg'],
  'stats' => [
    ['$0.03','flat rate','Per image. Size never changes the price — 1024² and 2560² bill one rate.'],
    ['2560px','max canvas','The largest text-to-image canvas — 256 to 2560 pixels per side.'],
    ['byte-exact','seeding','Two runs, one seed — one sha256. Same request, same asset, every rerun.'],
    ['256–2560','px per side','width and height, default 1024 × 1024.'],
    ['async','delivery','Poll the task or take the webhook.'],
    ['30','credits','Flat per image at any size.'],
  ],
  'features' => [
    ['title'=>'Detail that survives','desc'=>'Pore-level realism, natural light, a candid grade rather than studio polish. At the 2560px tier crops keep pores and eyelashes instead of smearing.','media'=>['type'=>'image','src'=>'/media/zimage/04.jpg']],
    ['title'=>'Unrestricted output','desc'=>'Explicit is the default, not a flag: no content filter sits between the prompt and the image. Explicit prompts render literally, at the same flat rate.','media'=>['type'=>'image','src'=>'/media/zimage/05.jpg']],
    ['title'=>'Print-ready imagery','desc'=>'Render up to 2560px per side for print layouts and high-DPI surfaces — the hero still is this tier at its ceiling.','media'=>['type'=>'image','src'=>'/media/zimage/03.jpg']],
  ],
  'usecases' => [
    ['Print-ready imagery','Up to 2560px per side for print layouts and high-DPI product surfaces.'],
    ['On-demand storefronts','Uncensored generation behind your own surface, billed flat per image.'],
    ['Reproducible batch pipelines','One prompt plus one seed returns a byte-identical image across runs.'],
  ],
  'howto' => 'Flat rate, seeded, async:',
  'code' => 'curl https://apiadult.online/v1/images \\
  -H "Authorization: Bearer $APIADULT_KEY" \\
  -H "Content-Type: application/json" \\
  -d \'{
    "model": "z-image-spicy-pro",
    "prompt": "...",
    "width": 2560,
    "height": 2560,
    "seed": 42
  }\'',
  'price' => '$0.03 / image · any size',
  'gallery' => [['type'=>'image','src'=>'/media/zimage/05.jpg'],['type'=>'image','src'=>'/media/zimage/06.jpg'],['type'=>'image','src'=>'/media/zimage/07.jpg'],['type'=>'image','src'=>'/media/zimage/08.jpg'],['type'=>'image','src'=>'/media/zimage/09.jpg'],['type'=>'image','src'=>'/media/zimage/10.jpg'],['type'=>'image','src'=>'/media/zimage/11.jpg'],['type'=>'image','src'=>'/media/zimage/12.jpg']],
],
'minimax-h3-spicy' => [
  'name' => 'MiniMax H3 Spicy',
  'slug' => 'minimax-h3-spicy',
  'cat'  => 'Video',
  'prov' => 'MiniMax',
  'badge'=> 'Unrestricted',
  'tagline' => 'Uncensored video from text or a first frame, 5–15s — audio always included.',
  'desc' => 'MiniMax H3 with no platform content filter: explicit prompts validated on live tasks. Every clip carries a generated audio track — ambience, movement and voice — included in the per-second rate.',
  'hero' => ['type'=>'video','src'=>'/media/minimax/09.mp4'],
  'stats' => [
    ['audio','always on','Sound is generated with the pixels — no separate TTS step.'],
    ['$0.02/s','480p','768p at $0.03/s; 1080p finals at the platform-lowest $0.04/s.'],
    ['4','modes','Text, frames, or references — one endpoint, one rate table.'],
    ['15s','max length','Up to fifteen seconds in one continuous take.'],
    ['3','ratios','16:9, 9:16, or 1:1 — set per request.'],
    ['1080p','lowest rate','The lowest 1080p per-second rate on the platform.'],
  ],
  'features' => [
    ['title'=>'Text to video','desc'=>'MiniMax does not soften an explicit prompt into metaphor — one prompt in, explicit clip out, with no first frame required.','media'=>['type'=>'image','src'=>'/media/minimax/01.jpg']],
    ['title'=>'Generated audio','desc'=>'Ambience, movement and voice matched to the screen. No separate TTS or muxing step in your pipeline.','media'=>['type'=>'video','src'=>'/media/minimax/10.mp4']],
    ['title'=>'Modes and ratios','desc'=>'Prompt-only, image_url for a first frame, last_frame_url to anchor the ending, or up to 4 reference images and 1 video. All modes share one rate table.','media'=>['type'=>'image','src'=>'/media/minimax/04.jpg']],
  ],
  'usecases' => [
    ['High-volume short clips','Lowest 1080p per-second rate, billed exactly per requested second.'],
    ['One integration, four modes','Text-to-video, first-frame, first+last-frame, omni-reference — one endpoint.'],
    ['Sound-on content','Clips ship with generated audio at no extra charge.'],
    ['Cinematic short-form','Night scenes, practical light, tungsten and firelight palettes.'],
  ],
  'howto' => 'From prompt to video in three steps:',
  'code' => 'curl https://apiadult.online/v1/videos \\
  -H "Authorization: Bearer $APIADULT_KEY" \\
  -H "Content-Type: application/json" \\
  -d \'{
    "model": "minimax-h3-spicy",
    "prompt": "[Static shot] Night, the back seat of a moving car...",
    "duration": 5,
    "resolution": "768p",
    "ratio": "16:9"
  }\'',
  'price' => 'from $0.02 / sec (480p) · audio included',
  'gallery' => [['type'=>'image','src'=>'/media/minimax/02.jpg'],['type'=>'image','src'=>'/media/minimax/03.jpg'],['type'=>'image','src'=>'/media/minimax/04.jpg'],['type'=>'image','src'=>'/media/minimax/05.jpg'],['type'=>'image','src'=>'/media/minimax/06.jpg'],['type'=>'image','src'=>'/media/minimax/07.jpg']],
],
];
}
