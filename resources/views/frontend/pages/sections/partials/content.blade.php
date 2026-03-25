 @if ($section->getTitle())
     <div class="cms-html mb-3">
         {!! $section->getTitle() !!}
     </div>
 @endif

 @if ($section->getContent())
     <div class="cms-html mb-4">
         {!! $section->getContent() !!}
     </div>
 @endif
