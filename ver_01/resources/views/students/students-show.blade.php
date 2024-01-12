@extends('layout')

@section('content')
    @php
        
        function test2($testfunctions)
        {
            if ($testfunctions === 0) {
                echo '不合格';
            } elseif ($testfunctions === 1) {
                echo '合格';
            } elseif ($testfunctions === 2) {
                echo '未定';
            } else {
                echo '';
            }
        }
        
        function test($testfunctions)
        {
            $result = [];
            if ($testfunctions == 5) {
                $result['port'] = 'N5';
                $result['width'] = 20;
                $result['color'] = '#dbedfb';
            } elseif ($testfunctions == 4) {
                // echo 'N2';
                $result['port'] = 'N4';
                $result['width'] = 40;
                $result['color'] = '#b9dff6';
            } elseif ($testfunctions == 3) {
                // echo 'N3';
                $result['port'] = 'N3';
                $result['width'] = 60;
                $result['color'] = '#97d1f6';
            } elseif ($testfunctions == 2) {
                // echo 'N4';
                $result['port'] = 'N2';
                $result['width'] = 80;
                $result['color'] = '#70c3ed';
            } elseif ($testfunctions == 1) {
                // echo 'N5';
                $result['port'] = 'N1';
                $result['width'] = 100;
                $result['color'] = '#40b8ea';
            } elseif ($testfunctions == 6) {
                // echo '未取得';
                $result['port'] = '未取得';
                $result['width'] = '';
                $result['color'] = '';
            } else {
                $result['port'] = '';
                $result['width'] = '';
                $result['color'] = '';
            }
        
            return $result;
        }
    @endphp
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">
                        <div>
                            <h3>人材-infomation</h3>
                        </div>
                    </div>
                    <div class="back col-md-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary float-end">Back</a>
                    </div>
                    <style>
                        /* CSS 電話インターフェース用 */
                        @media (max-width: 767px) {
                            .back {
                                position: fixed;
                                bottom: 0;
                                left: 0;
                                width: 100%;
                            }
                        }
                    </style>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-6">
                            <div>
                                <strong style="font-size: 20px">氏名:</strong>
                                <pre style="display: inline; font-size: 20px;">  {{ $student->name }}</pre>
                            </div>
                            <div>
                                <strong style="font-size: 20px">氏名（カタカナ）:</strong>
                                <pre style="display: inline; font-size: 20px;">  {{ $student->name_kana }}</pre>
                            </div>
                            <div>
                                <strong style="font-size: 20px">性別:</strong>
                                <pre style="display: inline; font-size: 20px;">  @php
                                    if ($student->sex === 0) {
                                        echo '不明';
                                    } elseif ($student->sex === 1) {
                                        echo '男';
                                    } else {
                                        echo '女';
                                    }
                                @endphp</pre>
                            </div>
                            <div>
                                <strong style="font-size: 20px">生年月日:</strong>
                                <pre style="display: inline; font-size: 20px;">  {{ $student->birthday }}</pre>
                            </div>
                            <div>
                                <strong style="font-size: 20px">年齢:</strong>
                                @if ($student->age == 0)
                                    <span style="font-size: 20px"></span>
                                @else
                                    <span style="font-size: 20px">{{ $student->age }}歳</span>
                                @endif
                            </div>
                            <div>
                                <strong style="font-size: 20px">出身国:</strong>
                                <pre style="display: inline; font-size: 20px;">  {{ $student->country }}</pre>
                            </div>
                            <div class="interview_staffs">
                                <div class="form-control">
                                    <strong style="font-size: 25px">1次面接</strong>
                                    <div>
                                        <strong style="font-size: 20px">実施日:</strong>
                                        <pre style="display: inline; font-size: 20px;">  {{ $student->first_interv_date }}</pre>
                                    </div>
                                    <div>
                                        <strong style="font-size: 20px">対応者名:</strong>
                                        <pre style="display: inline; font-size: 20px;">  {{ $student->first_interv_staff }}</pre>
                                    </div>
                                    <div>
                                        <strong style="font-size: 20px">合否:</strong>
                                        <pre style="display: inline; font-size: 20px;">  @php
                                            test2($student->first_interv_result);
                                        @endphp</pre>
                                    </div>
                                </div>
                                <div class="form-control">
                                    <strong style="font-size: 25px">2次面接</strong>
                                    <div>
                                        <strong style="font-size: 20px">実施日:</strong>
                                        <pre style="display: inline; font-size: 20px;">  {{ $student->sec_interv_date }}</pre>
                                    </div>
                                    <div>
                                        <strong style="font-size: 20px">対応者名:</strong>
                                        <pre style="display: inline; font-size: 20px;">  {{ $student->sec_interv_staff }}</pre>
                                    </div>
                                    <div>
                                        <strong style="font-size: 20px">合否:</strong>
                                        <pre style="display: inline; font-size: 20px;">  @php
                                            test2($student->sec_interv_result);
                                        @endphp</pre>
                                    </div>
                                </div>
                            </div>
                            <div class="form-control">
                                <strong style="font-size: 25px">インターン</strong>
                                <div>
                                    <strong style="font-size: 20px">実行日</strong>
                                    <pre style="display: inline; font-size: 20px;">  {{ $student->intern_interv_date }}</pre>
                                </div>

                                <div>
                                    <strong style="font-size: 20px">対応部署名:</strong>
                                    <pre style="display: inline; font-size: 20px;">  {{ $student->intern_department }}</pre>
                                </div>
                                <div>
                                    <strong style="font-size: 20px">合否:</strong>
                                    <pre style="display: inline; font-size: 20px;">  @php
                                        test2($student->intern_result);
                                    @endphp</pre>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <br>
                        <div>
                            <strong style="font-size: 20px">入職日:</strong>
                            <pre style="display: inline; font-size: 20px;">  {{ $student->hire_date }}</pre>
                        </div>
                        <div>
                            <strong style="font-size: 20px">電話番号:</strong>
                            <pre style="display: inline; font-size: 20px;"> {{ $student->phone }}</pre>
                        </div>
                        <div>
                            <strong style="font-size: 20px">メールアドレス:</strong>
                            <pre style="display: inline; font-size: 20px;">  {{ $student->email }}</pre>
                        </div>
                        @php
                            $jlptSkill = test($student->skill_jlpt);
                            $portJLPT = $jlptSkill['port'];
                            $widthJLPT = $jlptSkill['width'];
                            $colorJLPT = $jlptSkill['color'];
                            
                            $hearingSkill = test($student->skill_hearing);
                            $portHr = $hearingSkill['port'];
                            $widthHr = $hearingSkill['width'];
                            $colorHr = $hearingSkill['color'];
                            
                            $speakingSkill = test($student->skill_speaking);
                            $portSp = $speakingSkill['port'];
                            $widthSp = $speakingSkill['width'];
                            $colorSp = $speakingSkill['color'];
                            
                            $readingSkill = test($student->skill_reading);
                            $portRd = $readingSkill['port'];
                            $widthRd = $readingSkill['width'];
                            $colorRd = $readingSkill['color'];
                            
                            if ($arraySkills === 0) {
                                $boxShadow = '2px 2px 5px rgba(0, 0, 0, 0.5)';
                            } else {
                                $boxShadow = '';
                            }
                        @endphp
                        <style>
                            .skillcolumn-item {
                                height: 20px;
                                min-width: 50px;
                                box-shadow: {{ $boxShadow }};
                                width: var(--precent);
                                background-color: var(--precent1);
                                animation: growth ease 0.5s;
                            }

                            @keyframes growth {
                                from {
                                    opacity: 0;
                                    width: calc(var(--precent) - 100%);
                                }

                                to {
                                    opacity: 1;
                                    width: var(--precent);
                                }
                            }
                        </style>

                        <div class="interview_skill form-control">

                            <strong style="font-size: 20px">日本語(JLPT)スキル:{{ $portJLPT }}</strong>
                            <div>
                                <div class="skillcolumn-item"
                                    style="--precent:{{ $widthJLPT }}%;--precent1:{{ $colorJLPT }}"></div>
                            </div>
                            <div>
                                <strong style="font-size: 20px">ヒアリングスキル:{{ $portHr }}</strong>
                                <div class="skillcolumn-item"
                                    style="--precent:{{ $widthHr }}%;--precent1:{{ $colorHr }}"></div>
                            </div>
                            <div>
                                <strong style="font-size: 20px">スピーキングスキル:{{ $portSp }}</strong>
                                <div class="skillcolumn-item"
                                    style="--precent:{{ $widthSp }}%;--precent1:{{ $colorSp }}"></div>
                            </div>
                            <div>
                                <strong style="font-size: 20px">リーディングスキル:{{ $portRd }}</strong>
                                <div class="skillcolumn-item"
                                    style="--precent:{{ $widthRd }}%;--precent1:{{ $colorRd }}"></div>
                            </div>
                        </div>


                        <div>
                            <strong style="font-size: 20px">SEスキル:</strong>
                            <pre style="display: inline; font-size: 20px;" class="text-wrap"> {{ $student->skill_se }}</pre>
                        </div>
                        <strong style="font-size: 25px">学歴</strong><br>
                        <div>
                            <strong style="font-size: 20px">4大:</strong>
                            <pre style="display: inline; font-size: 20px;">  @php
                                if ($student->graduate_4 == 1) {
                                    echo '〇';
                                } else {
                                    echo '';
                                }
                            @endphp</pre>
                        </div>
                        <div>
                            <strong style="font-size: 20px">専門:</strong>
                            <pre style="display: inline; font-size: 20px;">  @php
                                if ($student->graduate_2 == 1) {
                                    echo '〇';
                                } else {
                                    echo '';
                                }
                            @endphp</pre>
                        </div>
                        <div>
                            <strong style="font-size: 20px">最終学歴:</strong>
                            <pre style="display: inline; font-size: 20px;">  {{ $student->graduate_school }}</pre>
                        </div>
                        <div>
                            <strong style="font-size: 20px">応募職種:</strong>
                            <pre style="display: inline; font-size: 20px;">  {{ $student->apply_department }}</pre>
                        </div>
                        <div>
                            <strong style="font-size: 20px">希望勤務地:</strong>
                            <pre style="display: inline; font-size: 20px;">  {{ $student->working_place }}</pre>
                        </div>
                        <div>
                            <strong style="font-size: 20px">現在の状況:</strong>
                            <pre style="display: inline; font-size: 20px;">  {{ $student->current_status }}</pre>
                        </div>
                    </div>
                </div>
                <br>
                <strong style="font-size: 20px">自由項目:</strong>
                <div class="form-control">
                    <pre style="display: inline; font-size: 20px;"class="text-wrap">  {{ $student->note }}</pre>
                </div>
            </div>
        </div>
    </div>
@endsection
