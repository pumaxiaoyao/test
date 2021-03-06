/**
 * Created by cz on 15/4/21.
 */

var EP_CODE = {
    403: 'forbidden',
    502: '系统繁忙',
    800: '参数有误',
    801: '传入参数必须为数字',
    802: '传入参数超过指定长度',
    970: 'cache busy',
    971: 'cache unavailable',
    980: 'db busy',
    981: 'db unavailable',
    990: 'credentials error',
    991: 'captcha error',
    995: '请输入验证码',
    998: '验证码有误',
    992: '无法获得配置信息',
    993: '获取ID失败',
    999: '未登录',
    1000: '登录已关闭',
    1001: '用户名或密码格式有误',
    1002: '用户名不存在或密码错误',
    1003: '用户已被锁定',
    1004: '登录服务异常，请联系客服',
    1005: '登录失败，请重试',
    1006: '密码错误次数过多，已锁定',
    1007: '用户名或密码错误-1',
    1008: '用户待审',
    1100: '注册失败，请重试',
    1101: '注册参数有误',
    1102: '用户名不允许注册',
    1103: '用户名已存在',
    1104: 'Email已经存在',
    1105: '手机号已经存在',
    1106: '无效的安全问题',
    1107: '注册已关闭，请联系客服',
    1108: '注册分发到消息队列失败',
    1120: '旧密码不能为空',
    1121: '旧密码信息错误',
    1050: '金额格式有误',
    1051: '金额必须大于1',
    1150: '请选登录',
    1080: '玩家余额不足',
    1081: '账户异常，请联系客服',
    1082: '获取账户失败',
    1200: '系统关闭存款功能',
    1201: '系统关闭存款功能',
    1202: '超过单日存款限制次数',
    1203: '存款金额不能低于最低限额',
    1204: '存款金额不能超过最高限额',
    1205: '有正在审核的申请',
    1208: '传入存款类型有误',
    1210: '首选银行Id有误',
    1211: '获取第三方支付平台信息失败',
    1212: '获取第三方存款队列信息失败',
    1213: '获取商户信息失败',
    1214: '获取商户平台配置信息失败',
    1215: '存款失败',
    1216: '获取ATM银行卡信息失败',
    1217: '未知错误，请联系管理员',
    1230: '无法获取存款申请信息',
    1231: '玩家信息有误',
    1232: '玩家账号信息有误',
    1234: '银行卡信息有误',
    1235: '无法获取审核任务信息',
    1236: '参数错误',
    1237: '无法获取玩家信息，或者玩家信息有误',
    1238: '无法获取玩家账户信息，或者账户信息有误',
    1239: '无法获取活动信息',
    1240: '参数错误',
    1241: '调整金额或者流水金额有误',
    1242: '红利金额或者流水金额有误',
    1243: '余额不足',
    1300: '系统关闭取款功能',
    1301: '超过单日取款限制次数',
    1302: '取款金额不能低于最低限额',
    1303: '取款金额不能高于最高限额',
    1304: '取款金额不能超过单日取款总额限制',
    1305: '银行卡信息已经存在，选择首选银行',
    1306: '取款开户银行与真实姓名不一致',
    1307: '已有未处理的取款申请',
    1308: '未知错误',
    1330: '无法获取取款申请，或申请单信息有误',
    1331: '取款金额，或者取款手续费有误',
    1332: '取款手续费承担方信息有误',
    1333: '流水未检查',
    1334: '出款手续费不能小于0',
    1222: '无法获取玩家信息',
    1223: '密保答案错误',
    1400: '无效的游戏平台',
    1401: '游戏平台繁忙，请稍后重试',
    1402: '游戏平台官方维护',
    1403: '奇迹游戏平台维护',
    1404: '游戏平台已关闭',
    1406: '游戏平台配置有误',
    1407: '游戏平台维护中',
    1408: '获取玩家参与游戏平台列表失败',
    1405: '转账服务繁忙，请稍后重试',
    1410: '无效响应结果',
    1411: 'http exception',
    1412: '玩家尚未注册到游戏平台',
    1413: '获取游戏平台余额失败，请重试',
    1414: '玩家注册游戏平台失败',
    1415: '游戏平台转出失败',
    1416: '转入游戏平台失败',
    1417: '创建转账到游戏失败',
    1418: '转账回滚到主账户失败，请联系客服',
    1419: '转出余额超过游戏平台余额',
    1420: '更新转账状态失败',
    1421: '转账初始化失败',
    1422: '转出游戏未知错误',
    1423: '无效的转账记录',
    1424: '转账记录刚生成不久，请过3分钟后再处理',
    1440: '游戏平台不允许转入，只允许转出',
    1425: '转账确认操作失败，请重试',
    1500: '无效的客服名',
    1501: '无效的部门标识',
    1502: '密码格式有误',
    1503: '无效的email格式',
    1504: '无效的手机号',
    1505: '创建客服失败',
    1506: '修改资料失败',
    1507: '无效客服标识',
    1508: '修改密码失败',
    1509: '修改客服状态失败',
    1510: '修改客服角色失败',
    1511: '参数有误',
    1550: '邮箱已经被使用',
    1551: '手机号已经被使用',
    1552: '无法获取代理信息',
    1553: '审核状态有误',
    1554: '无法获取代理信息，或者代理已经被审核',
    1555: '代理群组Id有误',
    1556: '无法获取代理审核任务',
    1600: '参数有误',
    1601: '银行字典信息有误',
    1602: '无法获取银行卡信息',
    1603: '无法获取第三方支付平台信息',
    1604: '银行代码有误',
    1605: '创建平台实例有误',
    1606: '银行卡已经绑定商户信息，无法设置为银行选项',
    1607: '银行卡余额不为0，不能作废',
    1650: '转账金额必须大于0',
    1651: '银行卡账户余额异常，请联系奇迹支持',
    1652: '转出账户余额不足',
    1653: '银行卡手工添加对账失败',
    1654: '银行卡余额不足',
    1655: '银行卡用途有误',
    1620: '参数有误',
    1621: '无法找到商户信息',
    1700: '获取ID ticket失败',
    1701: '生成返水任务参数有误',
    1702: '生成返水结任务失败',
    1703: '有进行中的任务，无法接着创建任务',
    1704: '无效的返水记录',
    1705: '返水失败（发放或归零）',
    1800: '已经生成该月的月结单',
    1801: '创建月结单失败',
    1802: '该对象月结已经完成',
    1803: '手工调整失败，请重试',
    1804: '调整本期实际发放佣金失败',
    1805: '当月佣金小于等于0，不能调整实际发放值',
    1806: '代理月结审核不允许跳级审核',
    1807: '请调整审核层级',
    1808: '代理月结审核失败，请重试',
    1809: '还不能开始本月结算',
    1810: '还无法开始审核该数据',
    1900: '无效的活动',
    1901: '无效的上传配置参数',
    1902: '编辑活动失败',
    1903: '调整活动状态失败',
    1904: '调整活动顺序失败',
    1920: '你未达到参与此活动的条件',
    1921: '你还有该活动下的申请待处理中，请耐心等待',
    1922: '你已经参与过此活动了，无法再申请了',
    1923: '活动已下架',
    1924: '无效的活动申请信息',
    1925: '活动申请失败，请重试',
    2000: '无效的上传',
    2001: '上传已关闭',
    2002: '上传格式不对',
    2003: '上传文件大小超过规定大小',
    2004: '上传失败，请重试',
    2005: '下载的文件不存在',
    2006: '无效的存款申请凭据'


};

function getError(code, key) {
    if (code in  EP_CODE) {
        return EP_CODE[code];
    }
    return '操作失败！';
}


function errorMsg(data) {
    if (data.c in  EP_CODE) {
        return EP_CODE[data.c];
    }
    return '未知错误！';
}