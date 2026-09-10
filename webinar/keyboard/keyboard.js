/* --------------------------
  상태 변수
---------------------------*/
let mode="ko"; // ko / en / sp
let shift=false;
let caps=false;
let jamos=[];

const display=document.getElementById("display");
const leftKeyboard=document.getElementById("leftKeyboard");
const numpad=document.getElementById("numpad");

/* --------------------------
  쌍자음 맵핑
---------------------------*/
const doubleMap={
    "ㄱㄱ":"ㄲ","ㄷㄷ":"ㄸ","ㅂㅂ":"ㅃ","ㅅㅅ":"ㅆ","ㅈㅈ":"ㅉ"
};

/* --------------------------
  PC 키보드 레이아웃
---------------------------*/
const numLine=[
    ["`","~"],["1","!"],["2","@"],["3","#"],["4","$"],["5","%"],
    ["6","^"],["7","&"],["8","*"],["9","("],["0",")"],["-","_"],["=","+"]
];

const en1=["q","w","e","r","t","y","u","i","o","p","[","]","\\"];
const en2=["","a","s","d","f","g","h","j","k","l",";","'"];
const en3=["","z","x","c","v","b","n","m",",",".","/","?",""];

const ko1=["ㅂ","ㅈ","ㄷ","ㄱ","ㅅ","ㅛ","ㅕ","ㅑ","ㅐ","ㅔ","[","]","\\"];
const ko2=["","ㅁ","ㄴ","ㅇ","ㄹ","ㅎ","ㅗ","ㅓ","ㅏ","ㅣ",";","'",""];
const ko3=["","ㅋ","ㅌ","ㅊ","ㅍ","ㅠ","ㅜ","ㅡ",",",".","/","?",""];

const sp1=["!","@","#","$","%","^","&","*","(",")"];
const sp2=["[","]","{","}",";",":","?","/","\\"];
const sp3=[".",",","<",">","'","\"","|"];

/* --------------------------
  숫자패드
---------------------------*/
const numpadKeys=[
    "Num", "/", "*", "-",
    "7","8","9","+",
    "4","5","6","",
    "1","2","3",
    "0","."
];

/* --------------------------
  한글 입력 조합
---------------------------*/
function pushHangul(c){
	
    if(jamos.length>0){
        const pair=jamos[jamos.length-1]+c;
        if(doubleMap[pair]){
            jamos[jamos.length-1]=doubleMap[pair];
            display.value=Hangul.assemble(jamos);
            return;
        }
    }
    jamos.push(c);
    display.value=Hangul.assemble(jamos);
}

/* --------------------------
  일반 문자 입력
---------------------------*/
function pushChar(c){
    jamos.push(c);
    display.value=jamos.join("");
}

/* --------------------------
  모드 전환 (완전 분리)
---------------------------*/
function changeMode(m){
	flushHangul();
    mode=m;
    shift=false;
    //jamos=[];
    renderKeyboard();
}

/* --------------------------
  렌더링
---------------------------*/
function renderKeyboard(){

    leftKeyboard.innerHTML="";
    numpad.innerHTML="";
	
	//$('#display').val($('#display').val());
    /* --- LEFT MAIN KEYBOARD --- */
    createRow(leftKeyboard,numLine.map(v=>shift?v[1]:v[0]));
	
    if(mode==="ko"){
        createRow(leftKeyboard, ko1);
        createRow(leftKeyboard, ko2);
        createRow(leftKeyboard, ko3);
    }
    if(mode==="en"){
        const F=x=>(caps||shift)?x.toUpperCase():x.toLowerCase();
        createRow(leftKeyboard, en1.map(F));
        createRow(leftKeyboard, en2.map(F));
        createRow(leftKeyboard, en3.map(F));
    }
    if(mode==="sp"){
        createRow(leftKeyboard, sp1);
        createRow(leftKeyboard, sp2);
        createRow(leftKeyboard, sp3);
    }

    /* 기능키 라인 */
    const funcRow=document.createElement("div");
    funcRow.className="key-row";
    funcRow.innerHTML=`
        <div class="key func" data-action="back" style='background:#E80000'>Back</div>
        <div class="key func ${shift?"active":""}" data-action="shift" style='width:80px;'>Shift</div>
        <div class="key func ${caps?"active":""}" data-action="caps" style="margin-left:25px;width:60px;">Caps</div>
        <div class="key func" data-action="ko" style="margin-left:30px;width:60px;">KR</div>
        <div class="key func" data-action="en" style="margin-left:35px;width:60px;">ENG</div>
        <div class="key func" data-action="sp" style='margin-left:40px;font-size:12px;width:80px;'>Special \ncharacters</div>
        <div class="key func space" data-action="space" style="margin-left:65px;width:253px;">SPACE</div>
        
        <div class="key func" data-action="clear" style='margin-left:140px;width:100px;background:#FFFFE3;color:#000'>CLEAR</div>
    `;//<div class="key func" data-action="enter">ENTER</div>
    leftKeyboard.appendChild(funcRow);

    /* --- NUMPAD --- */
    numpadKeys.forEach(k=>{
        const el=document.createElement("div");
        el.className="key";

        if(k==="Enter") el.classList.add("enter-big");
        if(k==="0") el.classList.add("zero-wide");

        el.dataset.key=k;
        el.textContent=k==="Num"?"Num\nLock":k;
        numpad.appendChild(el);
    });
}

/* --------------------------
  공용: 키 한 줄 생성
---------------------------*/
function createRow(container, keys){
    const row=document.createElement("div");
    row.className="key-row";
    keys.forEach(k=>{
        const el=document.createElement("div");
        el.className="key";
        el.dataset.key=k;
        el.textContent=k;
        row.appendChild(el);
    });
    container.appendChild(row);
}

/* --------------------------
  클릭 이벤트
---------------------------*/
document.addEventListener("click", e=>{
    const t=e.target;
    if(!t.classList.contains("key")) return;

    const key=t.dataset.key;
    const act=t.dataset.action;

    if(key){
        if(mode==="ko") pushHangul(key);
        else pushChar(key);

        if(shift){ shift=false; renderKeyboard(); }
        return;
    }

    if(act==="back") jamos.pop();
    else if(act==="space") jamos.push(" ");
    else if(act==="enter") jamos.push("\n");
    else if(act==="clear") jamos=[];
    else if(act==="shift") shift=!shift;
    else if(act==="caps") caps=!caps;

    else if(act==="ko") changeMode("ko");
    else if(act==="en") changeMode("en");
    else if(act==="sp") changeMode("sp");

    display.value=(mode==="ko")
        ? Hangul.assemble(jamos)
        : jamos.join("");

    renderKeyboard();
});


function flushHangul() {
    if (mode === "ko") {
        // 현재 진행 중인 한글 조합을 완성형 텍스트로 변환
        const combined = Hangul.assemble(jamos);
        jamos = combined.split(""); 
    }
}


/* 초기 렌더 */
renderKeyboard();