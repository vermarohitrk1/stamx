
<div>
    <h4 class="mb-2">
        Submit Application - In progress...
    </h4>
    <div class="row mb-4">
        <div class="col-12 min-height-300 py-primary">
            <h5 class="mb-3">Basic Information</h5>
            <table class="table table-borderless shadow font-size-90">
                <tbody>
                @if(!empty($candidateData))
                    @foreach($candidateData as $key => $candidateInfo)
                        @if($key == 1)
                            @foreach($candidateInfo as $filedId => $fieldValue)
                                <tr>
                                    <td class="text-muted width-150">{{ $jobFormField->getFieldLabel($filedId) }}</td>
                                    <td>{{ $fieldValue }}</td>
                                </tr>
                            @endforeach
                        @else
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
            <h5 class="mt-3">Others information</h5>
            @if(!empty($candidateData))
                <?php $breackCount = 1; ?>
                @foreach($candidateData as $key => $candidateInfo)
                    @if($key != 1)
                        <?php $count = 1; ?>
                        @if($breackCount < 5)
                        @foreach($candidateInfo as $filedId => $fieldValue)
                            @if($count == 1)
                                <div class="card border-0 shadow mt-3 p-2">
                                    <p class="mb-0">{{ $jobFormField->getFieldLabel($filedId) }}</p>
                                    <p class="mb-0 text-muted">{{ $fieldValue }}</p>
                                </div>
                            @endif
                            <?php $count++ ?>
                        @endforeach
                        @endif
                    @endif
                    <?php $breackCount++ ?>
                @endforeach
            @endif
        </div>
    </div>
</div>
