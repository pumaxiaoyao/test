/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package demo;

import java.io.IOException;
import java.net.Socket;
import java.security.GeneralSecurityException;
import java.security.SecureRandom;
import java.security.cert.CertificateException;
import java.security.cert.X509Certificate;
import javax.net.ssl.SSLContext;
import javax.net.ssl.SSLEngine;
import javax.net.ssl.SSLException;
import javax.net.ssl.SSLSession;
import javax.net.ssl.SSLSocket;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509ExtendedTrustManager;
import org.apache.http.conn.ssl.SSLConnectionSocketFactory;
import org.apache.http.conn.ssl.X509HostnameVerifier;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;

/**

 @author PROSYS
 */
public class HttpClient
{

    public static CloseableHttpClient createHttpClient()
    {
        CloseableHttpClient httpclient = HttpClients.custom().setSSLSocketFactory(createSSLConnSocketFactory()).build();

        return httpclient;
    }

    // 创建SSL安全连接
    private static SSLConnectionSocketFactory createSSLConnSocketFactory()
    {
        SSLConnectionSocketFactory sslsf = null;
        try {
            SSLContext sslContext = SSLContext.getInstance("SSL");
            sslContext.init(null, new TrustManager[]{new TrustAnyTrustManager()}, new SecureRandom());
            sslsf = new SSLConnectionSocketFactory(sslContext, new X509HostnameVerifier()
            {
                public boolean verify(String arg0, SSLSession arg1)
                {
                    return true;
                }

                public void verify(String host, SSLSocket ssl) throws IOException
                {
                }

                public void verify(String host, X509Certificate cert) throws SSLException
                {
                }

                public void verify(String host, String[] cns, String[] subjectAlts) throws SSLException
                {
                }
            });
        }
        catch (GeneralSecurityException e) {
            e.printStackTrace();
        }
        return sslsf;
    }

    private static class TrustAnyTrustManager extends X509ExtendedTrustManager
    {

        @Override
        public void checkClientTrusted(X509Certificate[] xcs, String string, Socket socket) throws CertificateException
        {
        }

        @Override
        public void checkServerTrusted(X509Certificate[] xcs, String string, Socket socket) throws CertificateException
        {
        }

        @Override
        public void checkClientTrusted(X509Certificate[] xcs, String string, SSLEngine ssle) throws CertificateException
        {
        }

        @Override
        public void checkServerTrusted(X509Certificate[] xcs, String string, SSLEngine ssle) throws CertificateException
        {
        }

        @Override
        public void checkClientTrusted(X509Certificate[] xcs, String string) throws CertificateException
        {
        }

        @Override
        public void checkServerTrusted(X509Certificate[] xcs, String string) throws CertificateException
        {
        }

        public X509Certificate[] getAcceptedIssuers()
        {
            return new X509Certificate[]{};
        }
    }
}
