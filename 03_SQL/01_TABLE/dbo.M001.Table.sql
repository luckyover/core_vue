/****** Object:  Table [dbo].[M001]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[M001](
	[company_cd] [smallint] NOT NULL,
	[company_nm1] [nvarchar](50) NULL,
	[company_nm2] [nvarchar](50) NULL,
	[company_kn_nm1] [nvarchar](50) NULL,
	[company_kn_nm2] [nvarchar](50) NULL,
	[company_ab_nm1] [nvarchar](50) NULL,
	[company_ab_nm2] [nvarchar](50) NULL,
	[company_zip] [nvarchar](8) NULL,
	[company_address1] [nvarchar](50) NULL,
	[company_address2] [nvarchar](50) NULL,
	[company_address3] [nvarchar](100) NULL,
	[company_tel] [nvarchar](20) NULL,
	[company_fax] [nvarchar](20) NULL,
	[company_url] [nvarchar](255) NULL,
	[registration_num] [nvarchar](15) NULL,
	[bank_cd] [nvarchar](4) NULL,
	[bank_branch_cd] [nvarchar](3) NULL,
	[bank_nm] [nvarchar](30) NULL,
	[bank_branch_nm] [nvarchar](30) NULL,
	[bank_account_div] [smallint] NULL,
	[bank_account_no] [nvarchar](15) NULL,
	[bank_account_nm] [nvarchar](50) NULL,
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
 CONSTRAINT [PK_m_company] PRIMARY KEY CLUSTERED 
(
	[company_cd] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
