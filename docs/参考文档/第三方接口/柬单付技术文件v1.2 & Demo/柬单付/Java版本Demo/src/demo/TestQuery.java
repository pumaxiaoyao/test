package demo;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;
import org.apache.http.NameValuePair;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;

public class TestQuery
{

    public static void main(String[] args) throws Exception
    {
        String key = "ec5dd8b1dc5ed9522ab83bbba10b1c4b";
        Map<String, String> map = new TreeMap();
        map.put("service", "trade.query");
        map.put("version", "1.0");
        map.put("merchantId", "180001");
        map.put("orderNo", "2018011512301500001");
        map.put("tradeDate", "20180115");
        map.put("tradeTime", "123015");
        map.put("sign", createSign(map, key));

        String reqUrl = "https://pay.jdanfpay.com/gateway";
        System.out.println("reqUrl：" + reqUrl);

        CloseableHttpResponse response = null;
        CloseableHttpClient client = null;
        String res = null;
        try {
            HttpPost httpPost = new HttpPost(reqUrl);
            List<NameValuePair> nvps = new ArrayList();
            for (String k : map.keySet()) {
                nvps.add(new BasicNameValuePair(k, map.get(k)));
            }
            httpPost.setEntity(new UrlEncodedFormEntity(nvps, "UTF-8"));
            httpPost.addHeader("Connection", "close");
            client = HttpClient.createHttpClient();
            response = client.execute(httpPost);
            if (response != null && response.getEntity() != null) {
                String content = EntityUtils.toString(response.getEntity(), "UTF-8");
                Map<String, String> resultMap = SignUtils.parseQuery(content);
                System.out.println("请求结果：" + content);

                if (resultMap.containsKey("sign")) {
                    if (!SignUtils.checkParam(resultMap, key)) {
                        res = "验证签名不通过";
                    }
                    else {
                        if (resultMap.get("repCode").equals("0001")) {
                            // 回传支付交易结果，详情请查看文档中的返回结果
                            String resultCode = resultMap.get("resultCode");
                        }
                    }
                }
            }
            else {
                res = "操作失败";
            }
        }
        catch (Exception e) {
            e.printStackTrace();
            res = "系统异常";
        }
        finally {
            if (response != null) {
                response.close();
            }
            if (client != null) {
                client.close();
            }
        }
    }

    private static String createSign(Map map, String key)
    {
        Map<String, String> params = SignUtils.paraFilter(map);
        params.put("key", key);
        StringBuilder buf = new StringBuilder((params.size() + 1) * 10);
        SignUtils.buildPayParams(buf, params, false);
        String preStr = buf.toString();
        String sign = MD5.sign(preStr, "UTF-8");

        return sign;
    }
}
