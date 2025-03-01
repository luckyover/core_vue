USE [SPARKLE_DEV]
GO

/****** Object:  Table [dbo].[M004]    Script Date: 2/22/2024 5:47:43 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[M004](
	[customer_cd] [int] NOT NULL,
	[billing_source_cd] [smallint] NOT NULL,
	[customer_nm] [nvarchar](50) NULL,
	[customer_kn_nm] [nvarchar](50) NULL,
	[customer_ab_nm] [nvarchar](30) NULL,
	[customer_zip] [nvarchar](8) NULL,
	[customer_address1] [nvarchar](50) NULL,
	[customer_address2] [nvarchar](50) NULL,
	[customer_address3] [nvarchar](100) NULL,
	[customer_tel] [nvarchar](20) NULL,
	[customer_fax] [nvarchar](20) NULL,
	[customer_department_nm] [nvarchar](30) NULL,
	[customer_manager_nm] [nvarchar](30) NULL,
	[customer_mail_address] [nvarchar](255) NULL,
	[customer_class_div1] [smallint] NULL,
	[customer_class_div2] [smallint] NULL,
	[customer_class_div3] [smallint] NULL,
	[billing_nm] [nvarchar](50) NULL,
	[billing_zip] [nvarchar](8) NULL,
	[billing_address1] [nvarchar](50) NULL,
	[billing_address2] [nvarchar](50) NULL,
	[billing_address3] [nvarchar](100) NULL,
	[billing_tel] [nvarchar](20) NULL,
	[billing_fax] [nvarchar](20) NULL,
	[billing_department_nm] [nvarchar](30) NULL,
	[billing_manager_nm] [nvarchar](30) NULL,
	[billing_mail_address] [nvarchar](255) NULL,
	[billing_closing_div] [smallint] NULL,
	[transfer_date1] [smallint] NULL,
	[transfer_date2] [smallint] NULL,
	[sales_employee_cd] [nvarchar](5) NULL,
	[price_list] [smallint] NULL,
	[reason_for_closure] [nvarchar](50) NULL,
	[remarks] [nvarchar](100) NULL,
	[cre_user_cd] [nvarchar](5) NULL,
	[cre_prg] [nvarchar](30) NULL,
	[cre_ip] [nvarchar](20) NULL,
	[cre_tm] [datetime2](7) NULL,
	[upd_user_cd] [nvarchar](5) NULL,
	[upd_prg] [nvarchar](30) NULL,
	[upd_ip] [nvarchar](20) NULL,
	[upd_tm] [datetime2](7) NULL,
	[del_user_cd] [nvarchar](5) NULL,
	[del_prg] [nvarchar](30) NULL,
	[del_ip] [nvarchar](20) NULL,
	[del_tm] [datetime2](7) NULL,
	[del_flg] [int] NULL,
 CONSTRAINT [PK_m_customer] PRIMARY KEY CLUSTERED 
(
	[customer_cd] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO